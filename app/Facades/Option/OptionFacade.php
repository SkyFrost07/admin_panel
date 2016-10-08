<?php

namespace App\Facades\Option;

use Illuminate\Support\Facades\Facade;

class OptionFacade extends Facade{
    public static function getFacadeAccessor() {
        return 'options';
    }
}

