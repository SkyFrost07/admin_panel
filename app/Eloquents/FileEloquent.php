<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use Storage;
use Image;

class FileEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\File $model) {
        $this->model = $model;
    }

    public function rules() {
        return [
            'file' => 'mimes:jpeg,png,gif,bmp,svg|max:10240'
        ];
    }

    public function all($args = []) {
        $opts = [
            'fields' => ['*'],
            'orderby' => 'created_at',
            'type' => '_all',
            'order' => 'desc',
            'per_page' => 20,
            'key' => '',
            'author' => -1,
            'page' => 1
        ];

        $opts = array_merge($opts, $args);

        $result = $this->model
                ->where('title', 'like', '%' . $opts['key'] . '%')
                ->select($opts['fields'])
                ->orderBy($opts['orderby'], $opts['order']);

        if ($opts['type'] != '_all'){
            $result = $result->where('type', $opts['type']);
        }
        
        if ($opts['author'] > -1) {
            $result = $result->where('author_id', $opts['author']);
        }

        if ($opts['per_page'] == -1) {
            $result = $result->get();
        } else {
            $result = $result->paginate($opts['per_page']);
        }
        return $result;
    }

    public function getImage($id, $size = 'thumbnail') {
        $item = $this->model->find($id);
        if ($item) {
            return $item->getImage($size);
        }
        return null;
    }

    public function insert($file) {
        $this->validator(['file' => $file], $this->rules());

        $name = $file->getClientOriginalName();
        $mimetype = $file->getClientMimeType();
        $extension = strtolower($file->getClientOriginalExtension());
        $type = $extension;
        $cut_name = $this->checkRename($name);
        $slug_name = str_slug($cut_name);

        $upload_dir = config('image.upload_dir', 'uploads/');

        if (in_array($extension, ['jpeg', 'jpg', 'png', 'bmp', 'gif', 'svg'])) {

            $type = 'image';
            $m_image = Image::make($file);
            $width = $m_image->width();
            $height = $m_image->height();
            $ratio = $width / $height;

            $sizes = config('image.image_sizes', [
                'thumbnail' => [
                    'width' => 80,
                    'height' => 80,
                    'crop' => true
                ],
                'medium' => [
                    'width' => 360,
                    'height' => 240,
                    'crop' => true
                ],
                'large' => [
                    'width' => 1368,
                    'height' => null,
                    'crop' => false
                ]
            ]);

            foreach ($sizes as $key => $value) {
                $w = $value['width'];
                $h = $value['height'];

                if ($w == null && $h == null) {
                    continue;
                }

                $rspath = $upload_dir . $key . '/' . $slug_name.'.'.$extension;

                $crop = $value['crop'];
                $r = ($h == null) ? 0 : $w / $h;

                if ($width > $w && $height > $h) {
                    if ($ratio > $r) {
                        $rh = $h;
                        $rw = ($h == null) ? $w : $width * $h / $height;
                    } else {
                        $rw = $w;
                        $rh = ($w == null) ? $h : $height * $w / $width;
                    }
                    $sh = round(($rh - $h) / 2);
                    $sw = round(($rw - $w) / 2);

                    $rsImage = Image::make($file)->resize($rw, $rh, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    if ($crop) {
                        $rsImage->crop($w, $h, $sw, $sh);
                    }

                    Storage::disk()->put($rspath, $rsImage->stream()->__toString());
                }
            }
        }

        $fullpath = $upload_dir . 'full/'. $slug_name.'.'.$extension;
        Storage::disk()->put($fullpath, file_get_contents($file));

        $item = new $this->model();
        $item->title = $cut_name;
        $item->url = $slug_name.'.'.$extension;
        $item->type = $type;
        $item->mimetype = $mimetype;
        $item->author_id = auth()->id();
        $item->save();

        return $item;
    }
    
    public function checkRename($originalName) {
        $upload_dir = config('image.upload_dir', 'uploads/'); 
        $cut_name = $this->cutName($originalName);
        $base_name = $cut_name['name'];
        $re_name = $base_name;
        $i = 1;
        while (Storage::disk()->exists($upload_dir.'full/'.$re_name.'.'.$cut_name['ext'])) {
            $re_name = $base_name.'-'.$i;
            $i++;
        }
        return $re_name;
    }
    
    public function cutName($originalName){
        $name_str = explode('.', $originalName);
        $extension = array_pop($name_str);
        return [
            'name' => implode('.', $name_str),
            'ext' => $extension
        ];
    }

    public function destroy($ids) {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $sizes = config('image.image_sizes');
        $sizes['full'] = [];
        $dir = config('image.upload_dir');

        try {
            foreach ($ids as $id) {
                $image = $this->model->find($id, ['id', 'url']);
                if ($image) {
                    foreach ($sizes as $key => $size) {
                        $path = $dir . $key . '/' . $image->url;
                        if (Storage::disk()->exists($path)) {
                            Storage::disk()->delete($path);
                        }
                    }
                    $image->delete();
                }
            }
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

}
