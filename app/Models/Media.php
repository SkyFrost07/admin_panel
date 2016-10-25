<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model {

    protected $table = 'medias';
    protected $fillable = ['thumb_id', 'thumb_type', 'author_id', 'slider_id', 'status', 'target', 'views', 'media_type'];

    public function joinLang($lang = null) {
        $locale = ($lang) ? $lang : current_locale();
        return $this->join('media_desc as md', function($join) use ($locale) {
                    $join->on('medias.id', '=', 'md.media_id')
                            ->where('md.lang_code', '=', $locale);
                });
    }

    public function langs() {
        return $this->belongsToMany('\App\Models\Lang', 'media_desc', 'media_id', 'lang_code');
    }

    public function author() {
        return $this->belongsTo('\App\User', 'author_id', 'id')
                        ->select('id', 'name');
    }

    public function albums() {
        return $this->belongsToMany('\App\Models\Tax', 'media_tax', 'media_id', 'tax_id');
    }

    public function getAlbums($lang = null) {
        $lang = $lang ? $lang : current_locale();
        return $this->belongsToMany('\App\Models\Tax', 'media_tax', 'media_id', 'tax_id')
                        ->join('tax_desc as td', 'taxs.id', '=', 'td.tax_id')
                        ->join('langs as lg', function($join) use ($lang) {
                            $join->on('td.lang_code', '=', 'lg.code')
                            ->where('lg.code', '=', $lang);
                        })
                        ->select(['taxs.id', 'td.slug', 'td.name'])
                        ->where('taxs.type', 'album');
    }

    public function str_status() {
        if ($this->status == 1) {
            return trans('manage.enable');
        }
        return trans('manage.disable');
    }
    
    public function thumbnail(){
        return $this->belongsTo('\App\Models\File', 'thumb_id', 'id');
    }
    
    public function getThumbnailSrc($size='thumbnail') {
        if ($this->thumbnail) {
            return $this->thumbnail->getSrc($size);
        }
        return null;
    }
    
    public function getThumbnail($size = 'thumbnail', $class = 'null') {
        if ($this->thumb_type == 'image' && $this->thumbnail) {
            return $this->thumbnail->getImage($size, $class);
        }
        return null;
    }

}
