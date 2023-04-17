<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\UserMenuItem;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Blade;
use pxlrbt\FilamentEnvironmentIndicator\FilamentEnvironmentIndicator;
use ShuvroRoy\FilamentSpatieLaravelHealth\Pages\HealthCheckResults;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\RedisCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;


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

        Filament::serving(function () {
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('My Profile')
                    ->url(route('filament.pages.my-profile'))
                    ->icon('heroicon-s-user-circle'),
            ]);
        });

        FilamentEnvironmentIndicator::configureUsing(function (FilamentEnvironmentIndicator $indicator) {
            $indicator->showBadge = fn () => true;
            $indicator->showBorder = fn () => true;
        }, isImportant: true);
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\CustomerOverview::class,
        ];
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
                                ->url('/app/users/timer')
                                ->icon('tabler-clock-hour-3')
                                ->sort(2)
                        ]),

                    NavigationGroup::make('Admin')
                        ->items([
                            NavigationItem::make('Users')
                                ->url('/app/users')
                                ->icon('heroicon-o-user-group')
                                ->sort(1),

                            NavigationItem::make('Roles')
                                ->url('/app/shield/roles')
                                ->icon('heroicon-o-shield-check')
                                ->sort(2),

                            NavigationItem::make('Task')
                                ->url('/app/tasks')
                                ->icon('tabler-subtask')
                                ->sort(3),   
                        ]),

                    NavigationGroup::make('Tools')
                        ->items([
                            NavigationItem::make('Calendar | ' . \Carbon\Carbon::today()->isoFormat('dddd, D MMM'))
                                ->url('/app/timex')
                                ->icon('timex-timex')
                                ->sort(1),

                            NavigationItem::make('Events')
                                ->url('/app/timex-events')
                                ->icon('heroicon-o-calendar')
                                ->sort(2),
                            NavigationItem::make('Page Hints')
                                ->url('/app/page-hints')
                                ->icon('heroicon-o-question-mark-circle')
                                ->sort(3)
                        ]),

                    NavigationGroup::make('Timedoctor')
                        ->items([

                            NavigationGroup::make('Timer')
                                ->items([
                                        NavigationItem::make('TD')
                                            ->url('/app/users/timer')
                                            ->icon('tabler-list-details')
                                            ->sort(1),
                                        NavigationItem::make('Teamwork')
                                            ->url('#')
                                            ->icon('tabler-list-details')
                                            ->sort(2),
                                    ]),
                            NavigationItem::make('Time Dashboard')
                                ->url('/app/time/dashboard')
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
                                ->url('/app/backups')
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