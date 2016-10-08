<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Eloquents\UserEloquent;
use App\Eloquents\RoleEloquent;

use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $user;
    protected $role;

    public function __construct(UserEloquent $user, RoleEloquent $role) {
        $this->user = $user;
        $this->role = $role;
    }
    
    public function index(Request $request){
        canAccess('read_users');
        
        $users = $this->user->all($request->all());
        return view('manage.user.index', ['items' => $users]);
    }
    
    public function create(){
        canAccess('publish_users');
        
        $roles = $this->role->all(['orderby' => 'id', 'order' => 'asc'])->lists('label', 'id'); 
        return view('manage.user.create', ['roles' => $roles]);
    }
    
    public function store(Request $request){
        canAccess('publish_users');
        
        try{
            $this->user->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function edit($id){
        canAccess('edit_my_user', $id);
        
        $item = $this->user->find($id);
        $roles = $this->role->all(['orderby' => 'id', 'order' => 'asc'])->lists('label', 'id');
        return view('manage.user.edit', ['item' => $item, 'roles' => $roles]);
    }
    
    public function update($id, Request $request){
        canAccess('edit_my_user', $id);
        try{
            $this->user->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function destroy($id){
        canAccess('remove_my_user', $id);
        
        if(!$this->user->destroy($id)){
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }
    
    public function multiAction(Request $request){
        if(!cando('manage_users')){
            return respons()->json(false);
        }
        return response()->json($this->user->actions($request));
    }
}
