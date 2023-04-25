<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use ShuvroRoy\FilamentSpatieLaravelHealth\Pages\HealthCheckResults as HealthCheckResults;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class HealthCheck extends HealthCheckResults
{
    use HasPageShield;
}
