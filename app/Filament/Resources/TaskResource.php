<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use App\Models\User;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeField;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableTagsColumn;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                Forms\Components\MultiSelect::make('user_id')                    
                    ->label('Assigned to')
                    ->relationship('assignees','user_id')
                    ->multiple()
                    ->options(User::pluck('name','id')->toArray()), 
                Textarea::make('description')->required(),                               
                TextInput::make('creator_id')
                    ->label('Creator')
                    ->default(auth()->user()->id)
                    ->disabled()
                    ->hint('Creator '.auth()->user()->name)
                    ->hintIcon('tabler-info-circle'),                    
                DatePicker::make('due_date')
                    ->label('Due Date')
                    ->minDate(now())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->description(fn (Task $record): string => $record->description)
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                BadgeableTagsColumn::make('users.name')
                    ->colors([
                        '#4caf50'
                    ])
                    ->searchable()
                    ->label('Assigned To'),
                BadgeColumn::make('creator.name')
                    ->colors([
                        'danger',
                    ])
                    ->label('Created By')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('due_date')->label('Due Date')->dateTime('j F Y')->searchable()->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('due_date_past')
                    ->label('Past')
                    ->query(fn (Builder $query): Builder => $query->where('due_date', '<', today())),
                Tables\Filters\Filter::make('due_date_today')
                    ->label('Today')
                    ->query(fn (Builder $query): Builder => $query->where('due_date', '=', today())),
                Tables\Filters\Filter::make('due_date_future')
                    ->label('Future')
                    ->query(fn (Builder $query): Builder => $query->where('due_date', '>', today())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // FilamentExportBulkAction::make('export')
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('ExportPDF')->defaultFormat('pdf')->label('Export PDF')->button()->color('success'),
                FilamentExportHeaderAction::make('ExportXLSX')->defaultFormat('xlsx')->label('Export Excel')->button()->color('success'),
                FilamentExportHeaderAction::make('ExportCSV')->defaultFormat('csv')->label('Export CSV')->button()->color('success'),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }    
}
