<?php

namespace App\Facades\Lang;

use Illuminate\Support\Facades\Facade;

class LangFacade extends Facade{
    public static function getFacadeAccessor() {
        return 'languages';
    }
}

