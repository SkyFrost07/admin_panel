<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eloquents\UserEloquent;
use Illuminate\Validation\ValidationException;
use Validator;

class UserController extends Controller {

    protected $user;

    public function __construct(UserEloquent $user) {
        $this->user = $user;
    }

    public function view($id, $slug='') {
        $user = $this->user->find($id, ['id', 'name', 'email', 'slug', 'gender', 'birth', 'image_url', 'created_at']);
        return view('front.account.profile', compact('user'));
    }

    public function update($id, Request $request) {;
        canAccess('edit_my_user');
        
        try {
            $this->user->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('auth.updated_profile'));
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->validator);
        }
    }
    
    public function getChangePass(){
        canAccess('edit_my_user');
        
        $user = auth()->user();
        return view('front.account.change_password', compact('user'));
    }
    
    public function updatePassword(Request $request){
        canAccess('edit_my_user');
        
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

}
