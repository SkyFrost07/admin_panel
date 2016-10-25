<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\FileEloquent;
use Illuminate\Validation\ValidationException;
use DB;
use App\Eloquents\UserEloquent;

class FileController extends Controller {

    protected $file;
    protected $user;

    public function __construct(FileEloquent $file, UserEloquent $user) {

        $this->file = $file;
        $this->user = $user;
    }

    public function index(Request $request) {
        canAccess('read_files');
        
        $files = $this->file->all($request->all());
        if($request->wantsJson() || $request->ajax()){
            return response()->json($files);
        }
        return view('manage.file.index', ['items' => $files]);
    }
    
    public function dialog(Request $request){
        canAccess('read_files');
        
        $params = $request->all();
        return view('files.dialog', compact('params'));
    }
    
    public function manage(){
        return view('manage.file.manage');
    }
    
    public function show($id, Request $request){
        $size = 'thumbnail';
        if($request->has('size')){
            $size = $request->get('size');
        }
        return $this->file->getImage($id, $size);
    }

    public function create() {
        canAccess('publish_files');
        
        return view('manage.file.create');
    }

    public function store(Request $request) {
        canAccess('publish_files');
        
        if (!$request->hasFile('files')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([], 422);
            }
            return redirect()->back()->withInput()->withErrors(['file' => trans('validation.required', ['attribute' => 'file'])]);
        }

        $files = $request->file('files');
        $results = [];

        foreach ($files as $file) {
            try {
                $newfile = $this->file->insert($file);
                $newfile->thumb_url = $newfile->getSrc('thumbnail');
                $newfile->full_url = $newfile->getSrc('full');
                array_push($results, $newfile);
            } catch (ValidationException $ex) {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json($ex->validator, 422);
                }
                return redirect()->back()->withInput()->withErrors($ex->validator);
            }
        }
        if($request->wantsJson() || $request->ajax()){
            return response()->json($results);
        }
        return redirect()->route('file.index')->with('succ_mess', trans('manage.store_success'));
    }

    public function edit($id) {
        canAccess('edit_my_file', $this->file->get_author_id($id));
        
        $item = $this->file->find($id);
        $users = null;
        if(cando('manage_files')){
            $users = $this->user->all()->lists('name', 'id')->toArray();
        }
        return view('manage.file.edit', compact('item', 'users'));
    }

    public function update($id, Request $request) {
        canAccess('edit_my_file', $this->file->get_author_id($id));
        
        try {
            $this->file->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }

    public function destroy($id) {
        canAccess('remove_my_file', $this->file->get_author_id($id));
        
        if (!$this->file->destroy($id)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) {
        return response()->json($this->file->actions($request));
    }

}
