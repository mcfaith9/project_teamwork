<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use ShuvroRoy\FilamentSpatieLaravelHealth\Pages\HealthCheckResults;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\RedisCheck;
use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;


class FilamentServiceProvider extends ServiceProvider
{
    // 4 CPU cores is probably/hopefully a reasonable default for modern machines -> could be made configurable
    // For a good explanation see https://scoutapm.com/blog/understanding-load-averages
    private static int $nCpuCores = 4;

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
     * Define your Filament services
     *
     * @return void
     */
    public function boot()
    {
        $this->customAdminMenu();
        $this->configureHealthCheck();

        Filament::registerRenderHook(
            'global-search.start',
            fn (): View => view('components/topbar-navigation-list'),
        );  
        // Filament::registerRenderHook(
        //     'global-search.end',
        //     fn (): string => Blade::render('Ctrl + / to search'),
        // );
    }


    private function customAdminMenu()
    {
        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
            return $builder->item(
                NavigationItem::make('Dashboard')
                    ->url(route('filament.pages.dashboard'))
                    ->label('Dashboard')
                    ->icon('heroicon-o-home'))
                ->groups([

                    NavigationGroup::make('Authentication')
                        ->items([
                            NavigationItem::make('Users')
                                ->url('/admin/users')
                                ->icon('heroicon-o-user-group')
                                ->sort(1),

                            NavigationItem::make('Roles')
                                ->url('/admin/shield/roles')
                                ->icon('heroicon-o-shield-check')
                                ->sort(2),
                        ]),

                    NavigationGroup::make('Tools')
                        ->items([
                            NavigationItem::make('Calendar | ' . \Carbon\Carbon::today()->isoFormat('dddd, D MMM'))
                                ->url('/admin/timex')
                                ->icon('timex-timex')
                                ->sort(1),

                            NavigationItem::make('Events')
                                ->url('/admin/timex-events')
                                ->icon('heroicon-o-calendar')
                                ->sort(2),
                            NavigationItem::make('Page Hints')
                                ->url('/admin/page-hints')
                                ->icon('heroicon-o-question-mark-circle')
                                ->sort(3)
                        ]),

                    NavigationGroup::make('System')
                        ->items([

                            NavigationItem::make('Application Health')
                                ->url(route('filament.pages.health-check-results'))
                                ->icon('heroicon-o-heart')
                                ->sort(1),

                            NavigationItem::make('Backups')
                                ->url('/admin/backups')
                                ->icon('heroicon-o-cog')
                                ->sort(2),
                        ]),                    
                ]);
        });
    }



    private function configureHealthCheck()
    {
        $checks = [
            DatabaseCheck::new(),
            CacheCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
            OptimizedAppCheck::new(),
            UsedDiskSpaceCheck::new(),
        ];

        Health::checks($checks);
    }
}