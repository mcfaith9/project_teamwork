<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as Widget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class TimeStatsOverview extends Widget
{
    protected function getCards(): array
    {
        $this_week_start = Carbon::now()->startOfWeek()->isoFormat('MMM D');
        $this_week_end = Carbon::now()->endOfWeek()->isoFormat('MMM D');
        $this_week = $this_week_start . ' - ' . $this_week_end;

        $last_week_start = Carbon::now()->sub(\Carbon\CarbonInterval::days(7))->startOfWeek()->isoFormat('MMM D');
        $last_week_end = Carbon::now()->sub(\Carbon\CarbonInterval::days(7))->endOfWeek()->isoFormat('MMM D');
        $last_week = $last_week_start . ' - ' . $last_week_end;

        return [
            Card::make('Time Worked Today', '00h 00m')
                ->description(\Carbon\Carbon::today()->isoFormat('dddd, D MMM')),
            Card::make('Time Worked This Week', '00h 00m')
                ->description($this_week),
            Card::make('Time Worked Last Week', '00h 00m')
                ->description($last_week),
            Card::make('Time Worked This Month', '00h 00m')
                ->description(\Carbon\Carbon::today()->isoFormat('MMM, YYYY'))
                ->chart([4, 5, 3, 7, 9, 8, 2, 9])
                ->color('success'),
        ];
    }
}
