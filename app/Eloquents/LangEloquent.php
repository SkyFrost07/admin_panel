<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use Illuminate\Validation\ValidationException;

class LangEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\Lang $model) {
        $this->model = $model;
    }

    public function rules($id = null) {
        if (!$id) {
            return [
                'name' => 'required',
                'code' => 'required|unique:langs,code',
                'icon' => 'required',
                'folder' => 'required',
                'unit' => 'required',
                'ratio_currency' => 'required|numeric'
            ];
        } else {
            return [
                'code' => 'required|unique:langs,code,'.$id
            ];
        }
    }

    public function all($args = []) {
        $opts = [
            'status' => 1,
            'fields' => ['*'],
            'orderby' => 'order',
            'order' => 'asc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
            'page' => 1
        ];

        $opts = array_merge($opts, $args);

        $results = $this->model
                ->whereNotIn('id', $opts['exclude'])
                ->where('name', 'like', '%'.$opts['key'].'%')
                ->orderBy($opts['orderby'], $opts['order'])
                ->select($opts['fields']);
        
        if($opts['status'] != -1){
            $results = $results->where('status', $opts['status']);
        }
        
        if($opts['per_page'] == -1){
            $results = $results->get();
        }else{
            $results = $results->paginate($opts['per_page']);
        }
        
        return $results;
    }

    function findByName($name, $fields = ['*']) {
        return $this->model->where('name', $name)->first($fields);
    }
    
    public function findByCode($code, $fields=['*']){
        return $this->model->where('code', $code)->first($fields);
    }
    
    public function getId($code){
        $item = $this->model->where('code', $code)->first(['id']);
        if($item){
            return $item->id;
        }
        return null;
    }
    
    public function getCurrent($fields=['*']){
        $current_locale = app()->getLocale();
        $lang = $this->model->where('code', $current_locale)->first($fields);
        return $lang;
    }

}
