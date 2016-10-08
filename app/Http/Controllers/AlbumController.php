<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eloquents\TaxEloquent;
use App\Eloquents\MediaEloquent;

class AlbumController extends Controller
{
    protected $album;
    protected $media;

    public function __construct(TaxEloquent $album, MediaEloquent $media) {
        $this->album = $album;
        $this->media = $media;
    }
    
    public function lists(Request $request){
        $albums = $this->album->all('album', $request->all());
        return view('front.album_lists', compact('albums'));
    }
    
    public function view($id, $slug=null){
        $album = $this->album->findByLang($id);
        $images = $this->media->all([
            'albums' => [$id]
        ]);
        return view('front.album', compact('album', 'images'));
    }
}
