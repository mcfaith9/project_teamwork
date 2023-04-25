<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class ListUsers extends ListRecords
{
    use HasPageShield;

    protected static string $resource = UserResource::class;

    protected function getShieldRedirectPath(): string {
        return '/app'; // redirect to the root index...
    }

    protected function getTitle(): string
    {
        return trans('filament-user::user.resource.title.list');
    }
}
