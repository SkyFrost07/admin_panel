<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';
    protected $primaryKey = 'option_key';
    
    public $incrementing = false; 

    protected $fillable = ['key', 'value', 'label', 'lang_code'];
    
    public $timestamps = false;
}
