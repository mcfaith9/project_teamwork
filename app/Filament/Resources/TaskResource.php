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
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableTagsColumn;
use Illuminate\Support\HtmlString;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->autofocus(),
                Forms\Components\MultiSelect::make('user_id')                    
                    ->label('Assigned to')
                    ->relationship('assignees','user_id')
                    ->multiple()
                    ->options(User::pluck('name','id')->toArray()),
                DatePicker::make('due_date')
                    ->label('Due Date')
                    ->minDate(now()),
                TextInput::make('creator_name')
                    ->label('Created by')
                    ->default(auth()->user()->name)
                    ->disabled()
                    ->hint('Creator: '.auth()->user()->name)
                    ->hintIcon('tabler-info-circle'),
                TextInput::make('creator_id')
                    ->default(auth()->user()->id)
                    ->hidden(),     
                Textarea::make('description')->required(), 
                // for subtask
                Forms\Components\Repeater::make('forSubtasks')
                    ->relationship('subtasks')
                    ->schema([
                        TextInput::make('title')->required(),
                        Textarea::make('description'),
                    ])
                    ->createItemButtonLabel('Add subtask')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Grid::make([
                    'lg' => 2,
                    '2xl' => 5,
                    'sm' => 12
                ])->schema([ 
                    Split::make([                        
                        TextColumn::make('title')
                            ->description(fn (Task $record): string => $record->description)
                            ->wrap()
                            ->searchable()
                            ->sortable(),                           
                    ])->columnSpan([
                        'lg' => 'full',
                        '2xl' => 2,
                    ]), 
                                 
                    BadgeableTagsColumn::make('users.name')
                        ->label('Assigned to')
                        ->colors([
                            '#4caf50'
                        ])
                        ->searchable(),
                    // TextColumn::make('creator.name')
                    //     ->label('Created By')
                    //     ->searchable()
                    //     ->sortable(),
                    TextColumn::make('attribute.tag')
                        ->default('-')
                        ->wrap()
                        ->sortable()
                        ->description(function (Task $record) {
                            $progress = $record->attribute ? $record->attribute->progress.'%' : '0%';
                            $html = <<<HTML
                                        <div class="mb-6 h-2 bg-gray-300 dark:bg-gray-600 rounded w-24">
                                            <div class="h-full bg-success-500 rounded" style="width: $progress;"></div>
                                        </div>
                                    HTML;
                            return new HtmlString('Progress '.$html);
                        }),
                    TextColumn::make('created_at')
                        ->dateTime('M j, Y')
                        ->searchable()
                        ->sortable()
                        ->description( function (Task $record) {
                            return 'Created by '.$record->creator->name;
                        }),                                              
                ]), 
                Panel::make([
                    TextColumn::make('subtasks.title')
                        ->description(function (Task $record): string {
                            $subtaskDescriptions = $record->subtasks->pluck('description')->filter();
                            return implode(', ', $subtaskDescriptions->all());
                        })
                        ->wrap(),
                ])->collapsible(),               
                  
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
                // Tables\Actions\EditAction::make(),
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
    
    /**
    * Returns an array of all the relations available in the system.
    *
    * @return array An array of relations, where each relation is represented as an associative array with the following keys:   
    */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
    * This method returns an array of all the pages in the system.
    *
    * @return array An array of pages, where each page is represented as an associative array with the following keys:
    */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }    
}
