<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\PostTypeEloquent;
use App\Eloquents\TaxEloquent;
use App\Eloquents\FileEloquent;

class ApiController extends Controller
{
    protected $post;
    protected $page;
    protected $cat;
    protected $file;
    protected $request;

    public function __construct(
            PostTypeEloquent $post, 
            PostTypeEloquent $page, 
            TaxEloquent $cat, 
            FileEloquent $file, 
            Request $request
    ) {
        $this->post = $post;
        $this->page = $page;
        $this->cat = $cat;
        $this->file = $file;
        $this->request = $request;
    }

    public function getPosts() {
        $posts = $this->post->all('post', $this->request->all());
        return response()->json($posts);
    }

    public function getPages() {
        $pages = $this->page->all('page', $this->request->all());
        return response()->json($pages);
    }

    public function getCats() {
        $cats = $this->cat->all('cat', $this->request->all());
        return response()->json($cats);
    }

    public function getFiles() {
        if(cando('read_files')) {
            return response()->json([], 402);
        }
        
        $files = $this->file->all($this->request->all());
        return response()->json($files);
    }
}
