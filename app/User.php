<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'email', 'password', 'birth', 'gender', 'status', 'image_url', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $dates = ['created_at', 'updated_at', 'birth'];


    public function role(){
        return $this->hasOne('\App\Models\Role', 'id', 'role_id');
    }
    
    public function caps(){
        return $this->role->caps;
    }
    
    public function status(){
        switch ($this->status){
            case -1:
                return trans('manage.trash');
            case 0:
                return trans('manage.banned');
            case 1:
                return trans('manage.active');
            default:
                return trans('amange.disable');
        }
    }
}
