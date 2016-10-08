<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eloquents\PostTypeEloquent;
use App\Eloquents\CommentEloquent;

class PostController extends Controller
{
    protected $post;
    protected $comment;

    public function __construct(PostTypeEloquent $post, CommentEloquent $comment) {
        $this->post = $post;
        $this->comment = $comment;
    }
    
    public function lists(Request $request){
        $posts = $this->post->all('post', $request->all());
        return view('front.post_lists', compact('posts'));
    }
    
    public function view($id, $slug=null){
        $post = $this->post->findByLang($id, ['posts.*', 'pd.*']);
        $comments = $this->comment->all([
            'post_id' => $id
        ]);
        return view('front.post_detail', compact('post', 'comments'));
    }
}
