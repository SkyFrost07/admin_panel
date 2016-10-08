<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Eloquents\CapEloquent;
use Illuminate\Validation\ValidationException;

class CapController extends Controller
{
    protected $cap;
    
    public function __construct(CapEloquent $cap) {
//        canAccess('manage_caps');
        
        $this->cap = $cap;
    }
    
    public function index(Request $request){
        $caps = $this->cap->all($request->all());
        return view('manage.cap.index', ['items' => $caps]);
    }
    
    public function create(){
        $highers = $this->cap->all(['orderby' => 'name'])->lists('name', 'name');
        $highers->prepend(trans('manage.selection'), '');
        return view('manage.cap.create', ['highers' => $highers]);
    }
    
    public function store(Request $request){
        try{
            $this->cap->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function edit($id){
        $item = $this->cap->find($id);
        $highers = $this->cap->all(['orderby' => 'name', 'exclude' => [$id], 'per_page' => -1])->lists('name', 'name');
        $highers->prepend(trans('manage.selection'), '');
        return view('manage.cap.edit', ['item' => $item, 'highers' => $highers]);
    }
    
    public function update($id, Request $request){
        try{
            $this->cap->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function destroy($id){
        if(!$this->cap->destroy($id)){
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }
    
    public function multiAction(Request $request){
        return response()->json($this->cap->actions($request));
    }
}
