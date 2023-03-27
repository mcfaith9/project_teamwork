<?php

namespace App\Filament\Pages;

use App\Settings\FooterSettings;
use Filament\Pages\SettingsPage;

class ManageFooter extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = FooterSettings::class;

    protected function getFormSchema(): array
    {
        return [
            // ...
        ];
    }
}
