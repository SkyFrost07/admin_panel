<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class File extends Model
{
    protected $table = 'files';
    
    protected $fillable = ['title', 'url', 'type', 'mimetype', 'author_id', 'created_at', 'updated_at'];
    
    public function author(){
        return $this->belongsTo('\App\User', 'author_id', 'id');
    }
    
    public function getSrc($size = 'full'){
        $image_sizes = config('image.image_sizes');
        if(!isset($image_sizes[$size])){
            $size = 'full';
        }
        $upload_dir = config('image.upload_dir');
 
        $src_file = $upload_dir.$size.'/'.$this->url;
        $file = Storage::disk()->exists($src_file); 
        if(!$file){
            return null;
        }
        if(config('filesystems.default') == 'local'){
            $src_file = 'app/'.$src_file;
        }
        return Storage::disk()->url($src_file);
    }
    
    public function getImage($size='full', $class=null){
        if($src = $this->getSrc($size)){
            return '<img class="img-fluid '.$class.'" src="'.$src.'" alt="No image">';
        }
        return null;
    }
}
