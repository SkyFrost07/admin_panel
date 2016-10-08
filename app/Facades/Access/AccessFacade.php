<?php

namespace App\Facades\Access;

use Illuminate\Support\Facades\Facade;

class AccessFacade extends Facade{
    public static function getFacadeAccessor(){
        return 'access';
    }
}