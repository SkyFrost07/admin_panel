<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lang extends Model {

    protected $table = 'langs';
    protected $fillable = ['name', 'code', 'icon', 'folder', 'unit', 'ratio_currency', 'order', 'status', 'default'];
    public $timestamps = false;

    public function switch_url() {
        $request = request();
        $locale = $this->code;
        if (!has_lang($locale)) {
            $locale = config('app.fallback_locale');
        }
        app()->setLocale($locale);
        $segments = $request->segments(); 
        $segments[0] = $locale;
        return '/'.implode('/', $segments);
    }

    public function icon() {
        if ($this->icon) {
            $src = '/images/flags/' . $this->icon;
            return '<img width="30" src="' . $src . '">';
        }
        return null;
    }

    public function status() {
        switch ($this->status) {
            case 1:
                return 'Active';
            case -1:
                return 'Disable';
        }
    }

    public function str_default() {
        if ($this->default == 1) {
            return 'Yes';
        }
        return 'No';
    }

    public function cats() {
        return $this->belongsToMany('\App\Models\Cat', 'tax_desc', 'lang_id', 'tax_id')
                        ->withPivot('name', 'slug', 'description', 'meta_desc', 'meta_keyword')
                        ->where('type', 'cat');
    }
    
    public function cat_pivot($cat_id){
        $item = $this->cats()->find($cat_id, ['id']);
        if($item){
            return $item->pivot;
        }
        return null;
    }
    
    public function tags(){
        return $this->belongsToMany('\App\Models\Tag', 'tax_desc', 'lang_id', 'tax_id')
                ->withPivot('name', 'slug', 'description', 'meta_keyword', 'meta_desc')
                ->where('type', 'tag');
    }
    
    public function tag_pivot($tag_id){
        $item = $this->tags()->find($tag_id, ['id']);
        if($item){
            return $item->pivot;
        }
        return null;
    }
    
    public function menucats(){
        return $this->belongsToMany('\App\Models\MenuCat', 'tax_desc', 'lang_id', 'tax_id')
                ->withPivot('name', 'slug')
                ->where('type', 'menucat');
    }
    
    public function menucat_pivot($menu_cat_id){
        $item = $this->menucats()->find($menu_cat_id, ['id']);
        if($item){
            return $item->pivot;
        }
        return null;
    }
    
    public function menus(){
        return $this->belongsToMany('\App\Models\Menu', 'menu_desc', 'lang_id', 'menu_id')
                ->withPivot('title', 'slug', 'link');
    }
    
    public function menu_pivot($menu_id){
        $item = $this->menus()->find($menu_id);
        if($item){
            return $item->pivot;
        }
        return null;
    }
    
    public function posts(){
        return $this->belongsToMany('\App\Models\Post', 'post_desc', 'lang_id', 'post_id')
                ->withPivot('title', 'slug', 'excerpt', 'content', 'custom', 'meta_keyword', 'meta_desc')
                ->where('post_type', 'post');
    }
    
    public function post_pivot($post_id){
        $item = $this->posts()->find($post_id);
        if($item){
            return $item->pivot;
        }
        return null;
    }

}
