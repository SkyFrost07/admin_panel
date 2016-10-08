<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $table = 'comments';
    protected $fillable = ['post_id', 'author_email', 'author_name', 'author_id', 'author_ip', 'content', 'status', 'agent', 'parent_id'];

    public function post() {
        return $this->belongsTo('\App\Models\PostType', 'post_id', 'id');
    }
    
    public function getPost($lang=null){
        $lang = $lang ? $lang : current_locale();
        return $this->post()
                ->join('post_desc as pd', 'posts.id', '=', 'pd.post_id')
                ->where('pd.lang_code', '=', $lang)
                ->select('pd.title', 'pd.slug', 'pd.post_id');
    }
    
    public function str_status(){
        if($this->status == 1){
            return trans('manage.enable');
        }
        return trans('manage.disable');
    }
}
