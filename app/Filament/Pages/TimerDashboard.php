<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\TimeStatsOverview;
use Carbon\Carbon;

class TimerDashboard extends Page
{
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

    public $thisWeek;

    public function mount() { 

        $carbonThisWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $carbonThisWeek[] = Carbon::now()->startOfWeek()->addDays($i)->format('D, M d, Y');
        }
        
        $this->thisWeek = $carbonThisWeek;
    }

}
