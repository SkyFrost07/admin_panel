<?php

namespace App\Facades\Access;

use App\Eloquents\CapEloquent;

class Access {

    protected $cap;

    public function __construct(CapEloquent $cap) {
        $this->cap = $cap;
    }

    public function can($cap) {
        if (!auth()->check()) {
            return false;
        }
        $user = auth()->user();
        $user_id = $user->id;
        $user_caps = $user->caps()->lists('name')->toArray();
        if(!$user_caps){
            return false;
        }
        $args = array_slice(func_get_args(), 1);
        $author = ($args) ? $args[0] : null;
        
        if (in_array($cap, $user_caps)) {
            if ($author && $user_id == $author) { 
                return true;
            } else if ($author && $user_id != $author) {
                $capitem = $this->cap->findByName($cap, ['higher']);
                if ($capitem) {
                    $higher = $capitem->higher;
                    if (in_array($higher, $user_caps)){
                        return true;
                    }
                }
            }else {
                return true;
            }
        }
        return false;
    }

    public function check() {
        $args = func_get_args();   
        $can = call_user_func_array([$this, 'can'], $args);
        if (!$can) {
            abort(403, trans('auth.authorize'));
        }
    }

}
