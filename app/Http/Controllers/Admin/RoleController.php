<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Eloquents\RoleEloquent;
use App\Eloquents\CapEloquent;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    protected $role;
    protected $cap;
    
    public function __construct(RoleEloquent $role, CapEloquent $cap) {
//        canAccess('manage_caps');
        
        $this->role = $role;
        $this->cap = $cap;
    }
    
    public function index(Request $request){
        $roles = $this->role->all($request->all());
        return view('manage.role.index', ['items' => $roles]);
    }
    
    public function create(){
        return view('manage.role.create');
    }
    
    public function store(Request $request){
        try{
            $this->role->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function edit($id){
        $item = $this->role->find($id);
        $caps = $this->cap->all(['orderby' => 'name', 'order' => 'asc', 'per_page' => -1]);
        return view('manage.role.edit', ['item' => $item, 'caps' => $caps]);
    }
    
    public function update($id, Request $request){
        try{
            $this->role->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function destroy($id){
        if(!$this->role->destroy($id)){
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }
    
    public function multiAction(Request $request){
        return response()->json($this->role->actions($request));
    }
}
