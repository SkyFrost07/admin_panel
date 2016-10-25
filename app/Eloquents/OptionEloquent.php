<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use Illuminate\Validation\ValidationException;
use Option;

class OptionEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\Option $model) {
        $this->model = $model;
    }
    
    public function rules(){
        return [
            'key' => 'required',
            'value' => 'required'
        ];
    }
    
    public function all($args=[]){
        $opts = [
            'field' => ['*'],
            'orderby' => 'option_key',
            'order' => 'asc',
            'per_page' => 20,
            'key' => '',
            'page' => 1
        ];
        
        $opts = array_merge($opts, $args);
        
        $opts = array_merge($opts, $args);
        
        return $this->model
                ->where('option_key', 'like', '%'.$opts['key'].'%')
                ->orderby($opts['orderby'], $opts['order'])
                ->paginate($opts['per_page']);
    }
    
    public function updateItem($key, $value, $lang=null) {
        $this->validator(['key' => $key, 'value' => $value], $this->rules());
        
        $lang = $lang ? $lang : current_locale();
        Option::update($key, $value, $lang);
    }
    
    public function updateAll($data){
        if($data){
            $langs = get_langs(['fields' => ['code']]);
            foreach ($langs as $lang){
                if(isset($data[$lang->code])){
                    $lang_data = $data[$lang->code];
                    foreach ($lang_data as $key => $value){
                        Option::update($key, $value, $lang->code);
                    }
                }
            }
        }
    }
    
    public function destroy($ids) {
        if(!is_array($ids)){
            $ids = [$ids];
        }
        if($ids){
            return $this->model->whereIn('option_key', $ids)->delete();
        }
    }

}
