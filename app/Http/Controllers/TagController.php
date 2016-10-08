<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eloquents\TaxEloquent;
use App\Eloquents\PostTypeEloquent;

class TagController extends Controller
{
    protected $tag;
    protected $post;

    public function __construct(TaxEloquent $tag, PostTypeEloquent $post) {
        $this->tag = $tag;
        $this->post = $post;
    }
    
    public function lists(Request $request){
        $tags = $this->tag->all('tag', $request->all());
        return view('front.tag_lists', compact('tags'));
    }
    
    public function view($id, $slug=null){
        $tag = $this->tag->findByLang($id);
        $posts = $this->post->all('post', [
            'field' => ['posts.*', 'pd.*'],
            'tags' => [$id]
        ]);
        return view('front.tag', compact('tag', 'posts'));
    }
}
