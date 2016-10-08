<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eloquents\CommentEloquent;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    protected $comment;
    
    public function __construct(CommentEloquent $comment) {
        $this->comment = $comment;
    }
    
    public function addComment(Request $request){
        try {
            $this->comment->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('front.comment_added'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
}
