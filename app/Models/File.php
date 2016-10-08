<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class File extends Model
{
    protected $table = 'files';
    
    protected $fillable = ['name', 'url', 'type', 'mimetype', 'rand_dir', 'author_id', 'created_at', 'updated_at'];
    
    public function author(){
        return $this->belongsTo('\App\User', 'author_id', 'id');
    }
    
    public function getSrc($size = 'full'){
        $image_sizes = config('app.image_sizes');
        if(!isset($image_sizes[$size])){
            $size = 'full';
        }
        $upload_dir = config('app.upload_dir');
 
        $srcdir = $upload_dir.$size.'/'.$this->rand_dir;
        $srcfiles = Storage::disk()->files($srcdir); 
        if(!$srcfiles){
            return null;
        }
        $file_path = $srcfiles[0];
        if(config('filesystems.default') == 'local'){
            $file_path = 'app/'.$srcfiles[0];
        }
        return Storage::disk()->url($file_path);
    }
    
    public function getImage($size='full', $class=null){
        if($src = $this->getSrc($size)){
            return '<img class="img-fluid '.$class.'" src="'.$src.'" alt="No image">';
        }
        return null;
    }
}
