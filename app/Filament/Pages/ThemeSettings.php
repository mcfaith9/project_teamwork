<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Pages\Actions\Action;
use Symfony\Component\Process\Process;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;

class ThemeSettings extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.theme-settings';

    public static ?string $title = 'Theme Settings';    

    protected static string $settings = ThemeSettings::class;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('copyright')
                ->label('Copyright notice')
                ->required(),
            Repeater::make('links')
                ->schema([
                    TextInput::make('label')->required(),
                    TextInput::make('url')
                        ->url()
                        ->required(),
                ]),
        ];
    }

    protected function getActions(): array
    {
        return [
            Action::make('settings')
                ->action('openSettingsModal')
                ->icon('heroicon-s-cog')
                ->requiresConfirmation()
                ->modalHeading('Change Theme Color')
                ->modalSubheading('Are you sure you\'d like to change color scheme?')
                ->modalButton('Yes, change it')
                ->form([
                    Forms\Components\Select::make('color_public_path')
                       ->options([
                           'vendor/yepsua-filament-themes/css/slate.css' => 'Slate',
                           'vendor/yepsua-filament-themes/css/gray.css' => 'Gray',
                           'vendor/yepsua-filament-themes/css/zinc.css' => 'Zinc',
                           'vendor/yepsua-filament-themes/css/red.css' => 'Red', 
                           // add more options here
                       ])
                       ->label('Select theme color')
                       ->placeholder('Select CSS Color'),
                ]),
        ];
    }

    public function openSettingsModal(): void
    {
        $this->dispatchBrowserEvent('open-settings-modal');
    }
}
