<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;

use Illuminate\Validation\ValidationException;

class CapEloquent extends BaseEloquent{
    protected $model;
    
    public function __construct(\App\Models\Cap $model) {
        $this->model = $model;
    }
    
    public function rules(){
        return [
            'name' => 'required|alpha_dash'
        ];
    }
    
    public function all($args=[]){
        $opts = [
            'fields' => ['*'],
            'orderby' => 'name',
            'order' => 'asc',
            'per_page' => -1,
            'exclude' => [],
            'key' => '',
            'page' => 1
        ];
        
        $opts = array_merge($opts, $args);
        
        $result = $this->model
                ->whereNotIn('name', $opts['exclude'])
                ->search($opts['key'])
                ->orderby($opts['orderby'], $opts['order'])
                ->select($opts['fields']);
        
        if($opts['per_page'] == -1){
            $result = $result->get();
        }else{
            $result = $result->paginate($opts['per_page']);
        }
        return $result;
    }
    
    public function update($id, $data) {
        $this->validator($data, $this->rules());
        
        $fillable = $this->model->getFillable();
        $data = array_only($data, $fillable);
        if (!isset($data['higher']) || !$data['higher']) {
            $data['higher'] = null;
        }
        return $this->model->where('name', $id)->update($data);
    }
    
    function findByName($name, $fields=['*']){
        return $this->model->where('name', $name)->select($fields)->first();
    }
    
}

