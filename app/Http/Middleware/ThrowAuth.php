<?php

namespace App\Http\Middleware;

use Closure;

class ThrowAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->check()){
            if(cando('accept_manage')){
                return redirect()->intended(route('dashboard')); 
            }
            return redirect()->intended(route('home'));
        }
        return $next($request);
    }
}
