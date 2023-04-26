<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class CreateTask extends CreateRecord
{
    use HasPageShield;
    
    protected static string $resource = TaskResource::class;
}
