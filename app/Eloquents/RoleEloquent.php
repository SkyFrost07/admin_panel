<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;

use Illuminate\Validation\ValidationException;

class RoleEloquent extends BaseEloquent{
    protected $model;
    
    public function __construct(\App\Models\Role $model) {
        $this->model = $model;
    }
    
    public function rules($id=null){
        $id = ($id) ? ','.$id : '';
        return [
            'name' => 'required|alpha_dash|unique:roles,name'.$id
        ];
    }
    
    public function all($args=[]){
        $opts = [
            'field' => ['*'],
            'orderby' => 'id',
            'order' => 'asc',
            'per_page' => 20,
            'key' => '',
            'page' => 1
        ];
        
        $opts = array_merge($opts, $args);
        
        return $this->model
                ->where('name', 'like', '%'.$opts['key'].'%')
                ->orderby($opts['orderby'], $opts['order'])
                ->paginate($opts['per_page']);
    }
    
    public function getDefaultId(){
        $item = $this->model->where('default', 1)->select('id')->first();
        if($item){
            return $item->id;
        }
        return 0;
    }
    
    public function update($id, $data){
        if($this->validator($data, $this->rules($id))){
            $item = $this->model->find($id);
            if(isset($data['label'])){
                $item->label = $data['label'];
            }
            $item->name = $data['name'];
            if(isset($data['default'])){
                $item->default = $data['default'];
            }
            if (isset($data['caps']) && $data['caps']) {
                $item->caps()->detach();
                $item->caps()->attach($data['caps']);
            }
            return $item->save();
        }else{
            throw new ValidationException($this->getError());
        }
    }
}

