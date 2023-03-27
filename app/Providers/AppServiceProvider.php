<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;

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
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('My Profile')
                    ->url(route('filament.pages.my-profile'))
                    ->icon('heroicon-s-user-circle'),
            ]);
        });

        // FilamentEnvironmentIndicator::configureUsing(function (FilamentEnvironmentIndicator $indicator) {
        //     $indicator->showBadge = fn () => false;
        //     $indicator->showBorder = fn () => true;
        // }, isImportant: true);
    }
}
