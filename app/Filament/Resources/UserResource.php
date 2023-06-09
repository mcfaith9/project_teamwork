<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use STS\FilamentImpersonate\Impersonate;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeField;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static function getNavigationLabel(): string
    {
        return trans('filament-user::user.resource.label');
    }

    public static function getPluralLabel(): string
    {
        return trans('filament-user::user.resource.label');
    }

    public static function getLabel(): string
    {
        return trans('filament-user::user.resource.single');
    }

    protected static function getNavigationGroup(): ?string
    {
        return config('filament-user.group');
    }

    protected function getTitle(): string
    {
        return trans('filament-user::user.resource.title.resource');
    }

    public static function form(Form $form): Form
    {
        $rows = [
            TextInput::make('name')->required()->label(trans('filament-user::user.resource.name')),
            TextInput::make('email')->email()->required()->label(trans('filament-user::user.resource.email')),
            Forms\Components\TextInput::make('password')->label(trans('filament-user::user.resource.password'))
                ->password()
                ->maxLength(255)
                ->dehydrateStateUsing(static function ($state) use ($form){
                    if(!empty($state)){
                        return Hash::make($state);
                    }

                    $user = User::find($form->getColumns());
                    if($user){
                        return $user->password;
                    }
            }),
        ];

        if(config('filament-user.shield')){
            $rows[] = Forms\Components\MultiSelect::make('roles')->relationship('roles', 'name')->label(trans('filament-user::user.resource.roles'));
        }

        $form->schema($rows);

        return $form;
    }

    public static function table(Table $table): Table
    {
        $table
            ->columns([
                TextColumn::make('id')->sortable()->label(trans('filament-user::user.resource.id')),
                TextColumn::make('name')
                    ->description(fn (User $record): string => $record->email)
                    ->sortable()
                    ->searchable()
                    ->label(trans('filament-user::user.resource.name')),
                BadgeColumn::make('roles.name')
                    ->colors([
                        'danger',
                    ])
                    ->label('Roles'),
                BooleanColumn::make('email_verified_at')
                    ->sortable()
                    ->searchable()
                    ->label(trans('filament-user::user.resource.email_verified_at')),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->label(trans('filament-user::user.resource.verified'))
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('unverified')
                    ->label(trans('filament-user::user.resource.unverified'))
                    ->query(fn (Builder $query): Builder => $query->whereNull('email_verified_at')),
            ])
            ->bulkActions([
                // FilamentExportBulkAction::make('export')
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('ExportPDF')->defaultFormat('pdf')->label('Export PDF')->button()->color('success'),
                FilamentExportHeaderAction::make('ExportXLSX')->defaultFormat('xlsx')->label('Export Excel')->button()->color('success'),
                FilamentExportHeaderAction::make('ExportCSV')->defaultFormat('csv')->label('Export CSV')->button()->color('success')
            ]);

        if(config('filament-user.impersonate')){
            $table->prependActions([
                Impersonate::make('impersonate'),
            ]);
        }

        return $table;
    }

    /**
    * This method returns an array of all the pages in the system.
    *
    * @return array An array of pages, where each page is represented as an associative array with the following keys:
    */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'mywork' => Pages\MyWork::route('/mywork'),
            'myprojects' => Pages\MyProjects::route('/myprojects'),
            'inbox' => Pages\Inbox::route('/inbox'),
            'timer' => Pages\Timer::route('/timer'),
        ];
    }    
}
