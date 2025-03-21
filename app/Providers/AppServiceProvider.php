<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void{
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void{
        Vite::prefetch(concurrency: 3);

//        Validator::extend('username', function ($attribute, $value, $parameters, $validator) {
//            // Lógica de validación, ejemplo:
//            return preg_match('/^[a-zA-Z0-9_\-]+$/', $value);
//        });
//        Validator::replacer('username', function ($message, $attribute, $rule, $parameters) {
//            return "El formato del $attribute es inválido";
//        });


    }
}
