<?php

namespace App\Facades\Post;

use App\Eloquents\PostTypeEloquent;

class Post{
    protected $post;
    
    public function __construct(PostTypeEloquent $post) {
        $this->post = $post;
    }
    
    public function query($type='post', $args = []){
        return $this->post->all($type, $args);
    }
}

