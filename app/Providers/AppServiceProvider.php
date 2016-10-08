<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
//        Facades
//        Permission
        $this->app->bind('access', 'App\Facades\Access\Access');
//        Languages
        $this->app->bind('languages', 'App\Facades\Lang\Lang');
//        Options
        $this->app->bind('options', 'App\Facades\Option\Option');
//        Post
        $this->app->bind('post-facade', 'App\Facades\Post\Post');
//        Tax
        $this->app->bind('tax-facade', 'App\Facades\Tax\Tax');
    }

}
