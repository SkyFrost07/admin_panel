<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cap extends Model
{
    protected $table = 'caps';
    protected $fillable = ['label', 'name', 'higher'];
    public $timestamps = false;
    protected $primaryKey = 'name';
    public $incrementing = false;

    public function scopeSearch($query, $key){
        return $query->where('name', 'like', "%$key%");
    }
    
    public function roles() {
        return $this->belongsToMany('\App\Models\Role', 'role_cap', 'cap_name', 'role_id');
    }
    
    public function setHigherAttribute($value) {
        if (!$value) {
            $value = null;
        }
        $this->attributes['higher'] = $value;
    }
}
