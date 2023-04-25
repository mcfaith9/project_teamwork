<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\TimeStatsOverview;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class TimerDashboard extends Page
{
    public $workData;

    protected static ?string $title = 'Time Dashboard';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.timer-dashboard';

    protected static ?string $slug = 'time/dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            TimeStatsOverview::class,
        ];
    }    

    public function mount() { 

        $workArr = array();

        // Get total work time for this week from the database
        $totalWorkThisWeek = \DB::table('task_time_log')
            ->select(\DB::raw('DATE(created_at) AS date'), \DB::raw('SUM(time_log) AS total_work'))
            ->where('user_id', auth()->id())
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->groupBy(\DB::raw('DATE(created_at)'));

        // Convert the query result to an array of associative arrays
        $totalWorkThisWeekArr = $totalWorkThisWeek->get()->toArray();

        // Transform the $totalWorkThisWeekArr into an associative array where the keys are the dates
        // and the values are the total work time for each date
        $totalWorkByDate = array_column($totalWorkThisWeekArr, 'total_work', 'date');

        // Create an array of dates for the current week
        $weekDates = [];
        for ($date = Carbon::now()->startOfWeek(); $date->lte(Carbon::now()->endOfWeek()); $date->addDay()) {
            $weekDates[$date->toDateString()] = 0;
        }

        // Merge the $totalWorkByDate array with the $weekDates array to create a new array that includes
        // all dates of the week and their respective total work time
        $weekTotalWork = array_merge($weekDates, $totalWorkByDate);

        // Loop through each date and display the value if it exists, otherwise display 0
        foreach ($weekTotalWork as $date => $totalWork) {
            // Convert milliseconds to hours, minutes, and seconds
            $interval = CarbonInterval::milliseconds($totalWork)->cascade();
            // Get total minutes from the interval
            $totalSeconds = $interval->totalSeconds;
            $totalMinutes = round($totalSeconds / 60, 2);
            // Calculate percentage of work completed based on an 8-hour workday
            $percentage = round(($totalMinutes / (8 * 60)) * 100, 2);
            // Create an array with the date, total work time, and percentage of work completed
            $workArr =  array(  
                'date' => date('D, M d, Y', strtotime($date)), 
                'value' => $interval->format('%hh %im %Ss'), 
                'percentage' => round($percentage, 2).'%'
            );
            // Add the array to the $allWorkArr array
            $allWorkArr[] = $workArr;
        }

        // Set the $workData property to $allWorkArr
        $this->workData = $allWorkArr;
    //end   
    }
//end
}
