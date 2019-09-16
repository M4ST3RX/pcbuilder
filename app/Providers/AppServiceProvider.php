<?php

namespace App\Providers;

use App\ComputerBrand;
use App\Shop;
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
        view()->composer('layouts.app', function($view)
        {
            $view->with('brands', ComputerBrand::where('bankrupted', false)->get());
        });
    }
}
