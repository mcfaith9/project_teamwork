<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as Backups;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Backup extends Backups
{
    use HasPageShield;
}
