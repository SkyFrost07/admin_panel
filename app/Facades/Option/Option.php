<?php

namespace App\Facades\Option;
use DB;

class Option{
    protected $option;
    
    public function __construct(\App\Models\Option $option) {
        $this->option = $option;
    }
    
    public function update($key, $value, $lang=null){
        $lang = $lang ? $lang : current_locale();
        return DB::table('options')->updateOrInsert(['option_key' => $key, 'lang_code' => $lang], ['value' => $value]);
    }
    
    public function get($key, $lang=null){
        $lang = $lang ? $lang : current_locale();
        $item = $this->option->where('option_key', $key)->where('lang_code', $lang)->first();
        if($item){
            return $item->value;
        }
        return null;
    }
}

