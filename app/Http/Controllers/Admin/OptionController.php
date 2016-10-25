<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Eloquents\OptionEloquent;
use App\Eloquents\FileEloquent;
use Illuminate\Validation\ValidationException;

class OptionController extends Controller
{
    protected $option;
    protected $file;

    public function __construct(OptionEloquent $option, FileEloquent $file) {
        canAccess('manage_options');
        
        $this->option = $option;
        $this->file = $file;
    }
    
    public function index(Request $request){
        $options = $this->option->all($request->all());
        return view('manage.option.index', ['items' => $options]);
    }
    
    public function create() {
        return redirect()->back();
    }
    
    public function store(Request $request){
        try{
            $value = $request->input('value');
            if ($request->has('file_ids') && $request->get('file_ids')) {
                $file_id = $request->get('file_ids')[0];
                $file = $this->file->find($file_id);
                $file_url = $file->getSrc('full');
                $value = $file_url;
            }
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
