<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eloquents\FileEloquent;

class AjaxController extends Controller
{
    protected $request;
    protected $file;

    public function __construct(Request $request, FileEloquent $file) {
        $this->request = $request;
        $this->file = $file;
    }
    
    public function action(){
        $action = $this->request->get('action');
        $result = '';
        switch ($action) {
            case 'load_files':
                $files = $this->file->all($this->request->all());
                if(!$files->isEmpty()){
                    foreach ($files as $file) {
                        $result .= '<li><a href="'.$file->getSrc('full').'" data-id="'.$file->id.'">';
                        $result .= $file->getImage('thumbnail');
                        $result .= '</a></li>';
                    }
                }
                break;
        }
        return $result;
    }
}
