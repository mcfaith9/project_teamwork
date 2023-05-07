<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\HtmlString;

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
            name: 'global-search.start',
            callback: fn (): View => view('components/topbar-navigation-list'),
        );

        Filament::registerRenderHook(
            name: 'scripts.start',
            callback: fn () => new HtmlString(html: "
                <script>
                    document.addEventListener('DOMContentLoaded', function(){
                       setTimeout(() => {
                            const activeSidebarItem = document.querySelector('.filament-sidebar-item-active');
                            const sidebarWrapper = document.querySelector('.filament-sidebar-nav')
                            
                            sidebarWrapper.style.scrollBehavior = 'smooth';
                            
                            sidebarWrapper.scrollTo(0, activeSidebarItem.offsetTop - 250)
                       }, 300)
                    });
                </script>
            "));

        Filament::registerScripts([
            'https://code.iconify.design/2/2.2.1/iconify.min.js',
            'https://code.jquery.com/jquery-3.6.0.min.js',
        ], true);
    }
}
