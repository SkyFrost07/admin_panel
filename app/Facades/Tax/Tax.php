<?php

namespace App\Facades;
use App\Eloquents\TaxEloquent;

class Tax{
    
    protected $tax;

    public function __construct(TaxEloquent $tax) {
        $this->tax = $tax;
    }
    
    public function query($type='cat', $args=[]){
        return $this->tax->all($type, $args);
    }
}

