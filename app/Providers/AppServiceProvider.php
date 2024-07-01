<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // https://www.patrickjunod.dev/blog/corriger-lerreur-syntax-error-or-access-violation-1071-la-cle-est-trop-longue-longueur-maximale-1000
        Schema::defaultStringLength(200);
    }
}
