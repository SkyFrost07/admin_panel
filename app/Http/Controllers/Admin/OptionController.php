<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Eloquents\OptionEloquent;
use Illuminate\Validation\ValidationException;

class OptionController extends Controller
{
    public function __construct(OptionEloquent $option) {
        canAccess('manage_options');
        
        $this->option = $option;
    }
    
    public function index(Request $request){
        $options = $this->option->all($request->all());
        return view('manage.option.index', ['items' => $options]);
    }
    
    public function store(Request $request){
        try{
            $value = $request->input('value');
            $this->option->updateItem($request->input('key'), $value, $request->input('lang_code'));
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function updateAll(Request $request){ 
        $this->option->updateAll($request->except(['_token', 'checked'])); 
        return redirect()->back()->with('succ_mess', trans('manage.update_success'));
    }
    
    public function destroy($id){
        if(!$this->option->destroy($id)){
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }
    
    public function multiAction(Request $request){
        return response()->json($this->option->actions($request));
    }
}
