<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    protected $opts = [
        'fields' => ['*'],
        'status' => 1,
        'orderby' => 'created_at',
        'order' => 'desc',
        'per_page' => 20,
        'exclude' => [],
        'key' => '',
        'cats' => [],
        'tags' => [],
        'with_cats' => false,
        'with_tags' => false
    ];

    public function all($args = []) {
        
    }

}
