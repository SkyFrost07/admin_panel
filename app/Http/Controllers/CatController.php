<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eloquents\TaxEloquent;
use App\Eloquents\PostTypeEloquent;

class CatController extends Controller
{
    protected $cat;
    protected $post;
    
    public function __construct(TaxEloquent $cat, PostTypeEloquent $post) {
        $this->cat = $cat;
        $this->post = $post;
    }
    
    public function view($id, $slug=null){
        $cat = $this->cat->findByLang($id, ['td.name', 'td.slug', 'taxs.id']);
        $posts = $this->post->all('post', [
            'field' => ['posts.*', 'pd.*'],
            'orderby' => 'created_at',
            'order' => 'desc',
            'cats' => [$id]
        ]);
        return view('front.category', compact('cat', 'posts'));
    }
}
