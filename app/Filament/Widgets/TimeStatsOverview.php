<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as Widget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Models\Task;
use App\Models\User;

class TimeStatsOverview extends Widget
{
    protected function getCards(): array
    {
        $user = auth()->user();

        $thisWeekStart = Carbon::now()->startOfWeek()->isoFormat('MMM D');
        $thisWeekEnd = Carbon::now()->endOfWeek()->isoFormat('MMM D');
        $thisWeek = $thisWeekStart . ' - ' . $thisWeekEnd;

        $lastWeekStart = Carbon::now()->sub(\Carbon\CarbonInterval::days(7))->startOfWeek()->isoFormat('MMM D');
        $lastWeekEnd = Carbon::now()->sub(\Carbon\CarbonInterval::days(7))->endOfWeek()->isoFormat('MMM D');
        $lastWeek = $lastWeekStart . ' - ' . $lastWeekEnd;
        
        // Get total work time for today
        $totalWorkToday = \DB::table('task_time_log')
            ->where('user_id', auth()->id())
            ->whereDate('created_at', today());

        // Pluck time logs from query result and convert to array of integers
        $totalWorkTodayAtrr = $totalWorkToday->pluck('time_log')->toArray();
        $totalWorkTodayAtrr = array_map(function($val) {
            return (int) substr($val, 0, 1);
        }, $totalWorkTodayAtrr);

        // Get total work time for this week
        $totalWorkThisWeek = \DB::table('task_time_log')
            ->where('user_id', auth()->id())
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);

        // Pluck time logs from query result and convert to array of integers
        $totalWorkThisWeekAtrr = $totalWorkThisWeek->pluck('time_log')->toArray();
        $totalWorkThisWeekAtrr = array_map(function($val) {
            return (int) substr($val, 0, 1);
        }, $totalWorkThisWeekAtrr);

        // Get total work time for last week
        $totalWorkLastWeek = \DB::table('task_time_log')
            ->where('user_id', auth()->id())
            ->whereBetween('updated_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);

        // Pluck time logs from query result and convert to array of integers
        $totalWorkLastWeekAtrr = $totalWorkLastWeek->pluck('time_log')->toArray();
        $totalWorkLastWeekAtrr = array_map(function($val) {
            return (int) substr($val, 0, 1);
        }, $totalWorkLastWeekAtrr);

        // Get total work time for this month
        $totalWorkThisMonth = \DB::table('task_time_log')
            ->where('user_id', auth()->id())
            ->whereMonth('created_at', Carbon::now()->month);

        // Pluck time logs from query result and convert to array of integers
        $totalWorkThisMonthAtrr = $totalWorkThisMonth->pluck('time_log')->toArray();
        $totalWorkThisMonthAtrr = array_map(function($val) {
            return (int) substr($val, 0, 1);
        }, $totalWorkThisMonthAtrr);

        $formattedTotalWorkToday = CarbonInterval::milliseconds($totalWorkToday->sum('prev_time_today'))->cascade()->format('%hh %im %Ss');
        $formattedTotalWorkThisWeek = CarbonInterval::milliseconds($totalWorkThisWeek->sum('prev_time_today'))->cascade()->format('%hh %im %Ss');
        $formattedTotalWorkLastWeek = CarbonInterval::milliseconds($totalWorkLastWeek->sum('prev_time_today'))->cascade()->format('%hh %im %Ss');
        $formattedTotalWorkThisMonth = CarbonInterval::milliseconds($totalWorkThisMonth->sum('prev_time_today'))->cascade()->format('%hh %im %Ss');

        return [
            Card::make('Time Worked Today', $formattedTotalWorkToday)
                ->description(\Carbon\Carbon::today()->isoFormat('dddd, D MMM'))
                ->chart($totalWorkTodayAtrr)
                ->color('success'),
            Card::make('Time Worked This Week', $formattedTotalWorkThisWeek)
                ->description($thisWeek)
                ->chart($totalWorkThisWeekAtrr)
                ->color('success'),
            Card::make('Time Worked Last Week', $formattedTotalWorkLastWeek)                
                ->description($lastWeek)
                ->chart($totalWorkLastWeekAtrr)
                ->color('success'),
            Card::make('Time Worked This Month', $formattedTotalWorkThisMonth)
                ->description(\Carbon\Carbon::today()->isoFormat('MMM, YYYY'))
                ->chart($totalWorkThisMonthAtrr)
                ->color('success'),
        ];
    }

 }
