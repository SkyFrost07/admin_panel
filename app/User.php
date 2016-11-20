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
        'name', 'slug', 'email', 'password', 'birth', 'gender', 'status', 'image_id', 'role_id'
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
        if ($this->role) {
            return $this->role->caps;
        }
        return null;
    }
    
    public function hasCaps($caps) {
        if (!is_array($caps)) {
            $caps = [$caps];
        }
        if ($this->role && $this->role->caps) {
            $user_caps = $this->role->caps()->whereIn('name', $caps)->get();
            return !$user_caps->isEmpty();
        }
        return false;
    }
    
    public function avatar() {
        return $this->belongsTo('\App\Models\File', 'image_id', 'id');
    }
    
    public function getAvatarSrc($size = 'thumbnail') {
        if ($this->avatar) {
            return $this->avatar->getSrc($size);
        }
        return null;
    } 
    
    public function getAvatar($size='thumbnail', $class='') {
        if ($this->avatar) {
            return $this->avatar->getImage($size, $class);
        }
        return null;
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
