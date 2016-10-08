<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\PostTypeEloquent;
use App\Eloquents\TaxEloquent;

class ApiController extends Controller
{
    protected $post;
    protected $page;
    protected $cat;
    protected $request;


    public function __construct(
            PostTypeEloquent $post, 
            PostTypeEloquent $page, 
            TaxEloquent $cat,
            Request $request
            ) {
        $this->post = $post;
        $this->page = $page;
        $this->cat = $cat;
        $this->request = $request;
    }
    
    public function getPosts(){
        $posts = $this->post->all('post', $this->request->all());
        return response()->json($posts);
    }
    
    public function getPages(){
        $pages = $this->page->all('page', $this->request->all());
        return response()->json($pages);
    }
    
    public function getCats(){
        $cats = $this->cat->all('cat', $this->request->all());
        return response()->json($cats);
    }
    
}
