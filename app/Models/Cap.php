<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cap extends Model
{
    protected $table = 'caps';
    protected $fillable = ['label', 'name', 'higher'];
    public $timestamps = false;


    public function scopeSearch($query, $key){
        return $query->where('name', 'like', "%$key%");
    }
}
