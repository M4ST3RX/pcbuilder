<?php

namespace App\Providers;

use App\Computer;
use App\CryptoWallet;
use App\Currency;
use App\Mine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
            if(Session::has('computer_id')) {
                $currencies = [];
                $computer = Computer::find(Session::get('computer_id'));
                if (!$computer)
                {
                    return $view;
                }
                foreach(json_decode($computer->wallet->currencies, true) as $id => $value) {
                    $curr = Currency::find($id);
                    $currencies[$curr->name] = $value;
                }
                $view->with('crypto_currencies', $currencies);
            }
            $view->with('mines', Mine::all());
        });
    }
}
