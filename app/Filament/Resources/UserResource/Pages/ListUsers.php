<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getTitle(): string
    {
        return trans('filament-user::user.resource.title.list');
    }
}
