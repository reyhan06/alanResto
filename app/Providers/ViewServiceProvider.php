<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {


        View::composer('layouts.app', function ($view) {
            $active_menu = [
                'products' => request()->routeIs('products.*'),
                'transactions' => request()->routeIs('transactions'),
            ];

            $view->with('active_menu', $active_menu);
        });
    }
}
