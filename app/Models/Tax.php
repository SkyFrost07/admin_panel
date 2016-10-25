<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'taxs';
    protected $fillable = ['image_id', 'type', 'parent_id', 'order', 'count', 'status'];

    public function joinLang($lang=null) {
        $lang = ($lang) ? $lang : current_locale();
        return $this->join('tax_desc as td', 'taxs.id', '=', 'td.tax_id')
                        ->where('td.lang_code', '=', $lang);
    }
    
    public function getName($lang=null){
        $item = $this->joinLang($lang)
                ->find($this->id, ['td.name']);
        if($item){
            return $item->name;
        }
        return null;
    }
    
    public function parent_name() {
        $item = $this->joinLang()
                ->where('taxs.id', $this->parent_id)
                ->first(['td.name']);

        if ($item) {
            return $item->name;
        }
        return null;
    }

    public function langs(){
        return $this->belongsToMany('\App\Models\Lang', 'tax_desc', 'tax_id', 'lang_code');
    }
    
    public function thumbnail() {
        return $this->belongsTo('\App\Models\File', 'image_id', 'id');
    }
    
    public function getThumbnailSrc($size) {
        if ($this->thumbnail) {
            return $this->thumbnail->getSrc($size);
        }
        return null;
    }
    
    public function getThumbnail($size='thumbnail', $class = null){
        if ($this->thumbnail) {
            return $this->thumbnail->getImage($size, $class);
        }
        return null;
    }
    
    public function status() {
        switch ($this->status) {
            case 0:
                return trans('manage.disable');
            case 1:
                return trans('manage.enable');
        }
    }
}
