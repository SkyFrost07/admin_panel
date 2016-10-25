<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    protected $table = 'posts';
    public $dates = ['trashed_at'];
    protected $fillable = ['thumb_id', 'thumb_ids', 'author_id', 'status', 'comment_status', 'comment_count', 'post_type', 'views', 'template', 'trased_at', 'created_at', 'updated_at'];

    public function joinLang($lang = null) {
        $locale = ($lang) ? $lang : current_locale();
        return $this->join('post_desc as pd', 'posts.id', '=', 'pd.post_id')
                        ->where('pd.lang_code', '=', $locale);
    }

    public function joinCats($ids = []) {
        $this->joinLang()
                ->join('post_tax as pt', function($join) use ($ids) {
                    $join->on('posts.id', '=', 'pt.post_id')
                    ->whereIn('tax_id', $ids);
                });
    }

    public function getCats($lang=null) {
        $lang = $lang ? $lang : current_locale();
        return $this->belongsToMany('\App\Models\Tax', 'post_tax', 'post_id', 'tax_id')
                        ->join('tax_desc as td', 'taxs.id', '=', 'td.tax_id')
                        ->where('td.lang_code', '=', $lang)
                        ->select(['taxs.id', 'td.slug', 'td.name', 'taxs.parent_id'])
                        ->where('taxs.type', 'cat');
    }
    
    public function cats(){
        return $this->belongsToMany('\App\Models\Tax', 'post_tax', 'post_id', 'tax_id')
                ->where('taxs.type', 'cat');
    }

    public function getTags($lang = null) {
        $lang = $lang ? $lang : current_locale();
        return $this->belongsToMany('\App\Models\Tax', 'post_tax', 'post_id', 'tax_id')
                ->join('tax_desc as td', 'taxs.id', '=', 'td.tax_id')
                        ->where('td.lang_code', '=', $lang)
                        ->select(['taxs.id', 'td.slug', 'td.name', 'taxs.parent_id'])
                        ->where('taxs.type', 'tag');
    }
    
    public function tags(){
        return $this->belongsToMany('\App\Models\Tax', 'post_tax', 'post_id', 'tax_id')
                ->where('taxs.type', 'tag');
    }

    public function author() {
        return $this->belongsTo('\App\User', 'author_id', 'id')
                        ->select('id', 'name');
    }
    
    public function comments(){
        return $this->hasMany('\App\Models\Comment', 'post_id', 'id');
    }

    public function langs() {
        return $this->belongsToMany('\App\Models\Lang', 'post_desc', 'post_id', 'lang_code')
                        ->where('post_type', 'post');
    }

    public function thumbnail() {
        return $this->belongsTo('\App\Models\File', 'thumb_id', 'id');
    }
    
    public function getThumbnail($size = 'thumbnail', $class='') {
        if ($this->thumbnail) {
            return $this->thumbnail->getImage($size, $class);
        }
        return null;
    }

    public function str_status() {
        if ($this->status == 0) {
            return trans('manage.trash');
        }
        return trans('manage.active');
    }
}
