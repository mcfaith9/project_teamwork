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
    }


    private function customAdminMenu()
    {
        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
            return $builder                               
                ->groups([

                    NavigationGroup::make(null)
                        ->items([
                            NavigationItem::make('Dashboard')
                                ->url(route('filament.pages.dashboard'))
                                ->icon('tabler-chart-treemap'),
                            NavigationItem::make('Timer')
                                ->url('/admin/users/timer')
                                ->icon('tabler-clock-hour-3')
                                ->sort(2)
                        ]),

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

                    NavigationGroup::make('Timedoctor')
                        ->items([

                            NavigationGroup::make('Timer')
                                ->items([
                                        NavigationItem::make('TD')
                                            ->url('#')
                                            ->icon('tabler-list-details')
                                            ->sort(1),
                                        NavigationItem::make('Teamwork')
                                            ->url('#')
                                            ->icon('tabler-list-details')
                                            ->sort(2),
                                    ]),
                            NavigationItem::make('Time Dashboard')
                                ->url('#')
                                ->icon('heroicon-o-chart-pie')
                                ->sort(2),
                            NavigationItem::make('Edit Time')
                                ->url('#')
                                ->icon('tabler-clock-edit')
                                ->sort(3),
                            NavigationItem::make('Report')
                                ->url('#')
                                ->icon('tabler-report')
                                ->sort(4),
                            NavigationItem::make('Help')
                                ->url('#')
                                ->icon('heroicon-o-question-mark-circle')
                                ->sort(5),
                        ]),

                    NavigationGroup::make('System')
                        ->items([

                            NavigationItem::make('Application Health')
                                ->url(route('filament.pages.health-check-results'))
                                ->icon('heroicon-o-heart')
                                ->sort(1),

                            NavigationItem::make('Backups')
                                ->url('/admin/backups')
                                ->icon('tabler-brand-google-drive')
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