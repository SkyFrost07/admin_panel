<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Eloquents\LangEloquent;

use Illuminate\Validation\ValidationException;

class LangController extends Controller
{
    protected $lang;
    
    public function __construct(LangEloquent $lang) {
        canAccess('manage_langs');
        
        $this->lang = $lang;
    }
    
    public function index(Request $request){
        $langs = $this->lang->all($request->all());
        return view('manage.lang.index', ['items' => $langs]);
    }
    
    public function create(){
        return view('manage.lang.create');
    }
    
    public function store(Request $request){
        try{
            $this->lang->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function edit($id){
        $item = $this->lang->find($id);
        return view('manage.lang.edit', ['item' => $item]);
    }
    
    public function update($id, Request $request){
        try{
            $this->lang->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function destroy($id){
        if(!$this->lang->destroy($id)){
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }
    
    public function multiAction(Request $request){
        return response()->json($this->lang->actions($request));
    }
}
