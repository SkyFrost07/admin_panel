<?php

namespace App\Facades\Lang;

use App\Eloquents\LangEloquent;

class Lang{
    protected $lang;
    
    public function __construct(LangEloquent $lang) {
        $this->lang = $lang;
    }
    
    public function all($args=[]){
        return $this->lang->all($args);
    }
    
    public function getCurrent($fields=['*']){
        return $this->lang->getCurrent(['id', 'name', 'code', 'icon']);
    }
    
    public function getId($code){
        return $this->lang->getId($code);
    }
    
    public function findByCode($code, $fields=['*']){
        return $this->lang->get_lang($code, $fields);
    }
    
    public function has($code){
        $item = $this->lang->findByCode($code, ['id']);
        if($item){
            return true;
        }
        return false;
    }
}

