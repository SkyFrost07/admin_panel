<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\PostEloquent;
use App\Eloquents\PageEloquent;
use App\Eloquents\CatEloquent;

class ApiController extends Controller
{
    protected $post;
    protected $page;
    protected $cat;
    protected $request;


    public function __construct(
            PostEloquent $post, 
            PageEloquent $page, 
            CatEloquent $cat,
            Request $request
            ) {
        $this->post = $post;
        $this->page = $page;
        $this->cat = $cat;
        $this->request = $request;
    }
    
    public function getPosts(){
        $posts = $this->post->all($this->request->all());
        return response()->json($posts);
    }
    
    public function getPages(){
        $pages = $this->page->all($this->request->all());
        return response()->json($pages);
    }
    
    public function getCats(){
        $cats = $this->cat->all($this->request->all());
        return response()->json($cats);
    }
    
}
