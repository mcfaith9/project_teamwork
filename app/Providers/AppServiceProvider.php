<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
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
        Filament::registerRenderHook(
            'global-search.start',
            fn (): View => view('components/topbar-navigation-list'),
        );  

        Filament::registerScripts([
            'https://code.iconify.design/2/2.2.1/iconify.min.js',
            'https://code.jquery.com/jquery-3.6.0.min.js',
        ], true);
    }
}
