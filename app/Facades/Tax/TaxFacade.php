<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TaxFacade extends Facade{
    public static function getFacadeAccessor() {
        return 'tax-facade';
    }
}

