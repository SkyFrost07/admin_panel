<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Mail;
use DB;
use Socialite;

class AuthController extends Controller
{
    protected $user;
    protected $role;

    public function __construct(\App\User $user, \App\Models\Role $role) {
        $this->user = $user;
        $this->role = $role;
    }
    
    public function getRegister(){
        return view('auth.register');
    }
    
    public function postRegister(Request $request){
        $valid = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        
        $this->user->create([
            'name' => $request->input('name'),
            'slug' => str_slug($request->input('name')),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'gender' => $request->input('gender'),
        ]);
        
        return redirect()->back()->with('succ_mess', trans('auth.succ_register'));
    }
    
    public function getLogin(){
        return view('auth.login');
    }
    
    public function postLogin(Request $request){
        $valid = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        
        $auth = auth()->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request->input('remember'));
        
        if(!$auth){
            return redirect()->back()->withInput()->with('error_mess', trans('auth.failed'));
        }
        
        if(cando('accept_manage')){
            return redirect()->intended(route('dashboard'));
        }
        return redirect()->intended(route('home'));
    }
    
    public function logout(){
        if(auth()->check()){
            auth()->logout();
        }
        return redirect()->route('get_login');
    }
    
    public function getForgetPass(){
        return view('auth.forget_password');
    }
    
    public function postForgetPass(Request $request){
        $valid = Validator::make($request->all(), [
           'email' => 'email|required|exists:users,email' 
        ]);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        
        $email = $request->input('email');
        
        DB::beginTransaction();
        $user = $this->user->where('email', $email)->first();
        $token = makeToken(40, $this->user);
        $user->resetPasswdToken = $token;
        $user->resetPasswdExpires = time()+3600;
        $user->save();
        
        Mail::send('mails.reset_password', ['email' => $email, 'token' => $token], function($mail) use ($email){
            $mail->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
            $mail->to($email);
            $mail->subject(trans('auth.reset_pass_subject', ['host' => request()->getHost()]));
        });
        if(count(Mail::failures()) > 0){
            DB::rollBack();
            return redirect()->back()->withInput()->with('error_mess', trans('auth.failure_send_mail'));
        }
        
        DB::commit();
        return redirect()->back()->with('succ_mess', trans('auth.reset_pass_mail_sent'));        
    }
    
    public function getResetPass(Request $request){
        $valid = Validator::make($request->all(), [
            'token' => 'required'
        ]);
        $error_view = view('errors.alert', ['mess' => trans('error.invalid_token')]);
        if($valid->fails()){
            return $error_view;
        }
        
        $token = $request->get('token');
        $user = $this->user->where('resetPasswdToken', $token)->where('resetPasswdExpires', '>', time())->first();
        if(!$user){
            return $error_view;
        }
        return view('auth.reset_password', ['token' => $token]);
    }
    
    public function postResetPass(Request $request){
        $valid = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);
        if($valid->fails()){
           return redirect()->back()->withInput()->withErrors($valid->errors()); 
        }
        
        $token = $request->input('token');
        $user = $this->user->where('resetPasswdToken', $token)->where('resetPasswdExpires', '>', time())->first();
        if(!$user){
            return view('errors.alert', ['mess' => trans('error.invalid_token')]);
        }
        
        $user->password = bcrypt($request->input('password'));
        $user->resetPasswdToken = '';
        $user->resetPasswdExpires = 0;
        $user->save();
        
        return redirect()->route('get_login')->with('succ_mess', trans('auth.reset_pass_success'));
    }
    
    public function getProfile(){
        $roles = $this->role->all()->lists('label', 'id')->toArray();
        return view('manage.account.profile', compact('roles'));
    }
    
    public function updateProfile(Request $request){
        $valid = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        $data = $request->all();
        $birth = $data['birth'];
        $data['birth'] = date('Y-m-d H:i:s', strtotime($birth['year'].'-'.$birth['month'].'-'.$birth['day']));
        $data['image_url'] = cutImgPath($data['image_id']);
        $fillable = $this->user->getFillable();
        $fill_data = array_only($data, $fillable);
        $this->user->where('id', auth()->id())->update($fill_data);
        return redirect()->back()->with('succ_mess', trans('auth.updated_profile'));
    }
    
    public function getChangePass(){
        return view('manage.account.change_password');
    }
    
    public function updatePassword(Request $request){
        $valid = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        $user = auth()->user();
        $check = \Hash::check($request->input('old_password'), $user->password);
        if(!$check){
            return redirect()->back()->withInput()->with('error_mess', trans('auth.invalid_pass'));
        }
        if(!$this->user->find($user->id)->update(['password' => bcrypt($request->input('new_password'))])){
            return redirect()->back()->withInput()->with('error_mess', trans('auth.error_database'));
        }
        return redirect()->back()->with('error_mess', trans('auth.updated_pass'));
    }
    
    public function redirectFacebook(){
        return Socialite::driver('facebook')->redirect();
    }
    
    public function handleFacebook(){
        $fb_user = Socialite::driver('facebook')->user();
        $email = $fb_user->email;
        $user = $this->user->where('email', $email)->first();
        if($user){
            auth()->login($user);
            return redirect()->intended(route('home'));
        }else{
            return redirect()->back()->with('error_mess', trans('auth.failed'));
        }
    }
}
