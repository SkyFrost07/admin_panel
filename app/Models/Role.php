<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $table = 'roles';
    protected $fillable = ['label', 'name', 'default'];
    public $timestamps = false;

    public function caps() {
        return $this->belongsToMany('\App\Models\Cap', 'role_cap', 'role_id', 'cap_id');
    }

    public function str_default() {
        if ($this->default == 0) {
            return trans('manage.no');
        }
        return trans('manage.yes');
    }

}
