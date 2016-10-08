<?php

namespace App\Composers;

use App\Eloquents\LangEloquent;

class LangComposer{
    
    protected $lang;

    public function __construct(LangEloquent $lang) {
        $this->lang = $lang;
    }

    public function compose($view){
        $langs = $this->lang->all(['fields' => ['id', 'code', 'name']]);
        $view->with('langs', $langs);
    }
    
}

