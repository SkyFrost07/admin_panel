<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use App\Eloquents\RoleEloquent;
use Illuminate\Validation\ValidationException;

class UserEloquent extends BaseEloquent {

    protected $model;
    protected $elRole;

    public function __construct(\App\User $model, RoleEloquent $elRole) {
        $this->model = $model;
        $this->elRole = $elRole;
    }

    public function rules($id = null) {
        if (!$id) {
            return [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed'
            ];
        }
        return [
            'name' => 'required',
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'min:6'
        ];
    }

    public function all($args = []) {
        $opts = [
            'status' => 1,
            'field' => ['*'],
            'orderby' => 'id',
            'order' => 'asc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
            'page' => 1
        ];

        $opts = array_merge($opts, $args);

        return $this->model->where('status', $opts['status'])
                        ->whereNotIn('id', $opts['exclude'])
                        ->where('email', 'like', '%' . $opts['key'] . '%')
                        ->orderby($opts['orderby'], $opts['order'])
                        ->paginate($opts['per_page']);
    }

    public function insert($data) {
        $this->validator($data, $this->rules());

        $item = new $this->model();
        $data['password'] = bcrypt($data['password']);
        $data['slug'] = str_slug($data['name']);
        if (!isset($data['role_id']) || $data['role_id'] != 0) {
            $data['role_id'] = $this->elRole->getDefaultId();
        }
        return $item->create($data);
    }

    public function update($id, $data) {
        $this->validator($data, $this->rules($id));
        
        $fillable = $this->model->getFillable();
        if (isset($data['password']) && ($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $data['slug'] = str_slug($data['name']);
        $birth = $data['birth'];
        $data['birth'] = date('Y-m-d H:i:s', strtotime($birth['year'].'-'.$birth['month'].'-'.$birth['day']));
        $data['image_url'] = cutImgPath($data['image_id']);
        $data = array_only($data, $fillable);
        return $this->model->where('id', $id)->update($data);
    }

}
