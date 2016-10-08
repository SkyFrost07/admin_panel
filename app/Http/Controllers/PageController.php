<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Eloquents\PostTypeEloquent;

class PageController extends Controller
{
    protected $page;
    
    public function __construct(PostTypeEloquent $page) {
        $this->page = $page;
    }
    
    public function lists(Request $request){
        $pages = $this->page->all('page', $request->all());
        return view('front.page_lists', compact('pages'));
    }
    
    public function view($id, $slug=null){
        $page = $this->page->findByLang($id);
        if(trim($page->template)){
            return view('front.templates.'.$page->template, compact('page'));
        }
        return view('front.page_detail', compact('page'));
    }
}
