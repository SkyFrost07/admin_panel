<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Eloquents\CommentEloquent;

use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    protected $comment;

    public function __construct(CommentEloquent $comment) {
        $this->comment = $comment;
    }
    
    public function index(Request $request){
        $items = $this->comment->all($request->all());
        return view('manage.comment.index', compact('items'));
    }
    
    public function create(){
        canAccess('publish_comments');
        
        $parents = $this->comment->all([
            'fields' => ['id', 'parent_id'],
            'per_page' => -1,
            'orderby' => 'id'
        ]);
        return view('manage.comment.create', compact('parents'));
    }
    
    public function store(Request $request){
        canAccess('publish_comments');
        
        try{
            $this->comment->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function edit($id){
        canAccess('edit_my_comment', $this->comment->get_author_id($id));
        
        $parents = $this->comment->all([
            'fields' => ['id', 'parent_id'],
            'per_page' => -1,
            'orderby' => 'id'
        ]);
        $item = $this->comment->find($id); 
        return view('manage.comment.edit', compact('item', 'parents'));
    }
    
    public function update($id, Request $request){
        canAccess('edit_my_comment', $this->comment->get_author_id($id));
        
        try{
            $this->comment->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function destroy($id){
        canAccess('remove_my_comment', $this->comment->get_author_id($id));
        
        if(!$this->comment->destroy($id)){
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }
    
    public function multiAction(Request $request){
        if(!cando('remove_other_comments')){
            return respons()->json(false);
        }
        return response()->json($this->comment->actions($request));
    }
    
}
