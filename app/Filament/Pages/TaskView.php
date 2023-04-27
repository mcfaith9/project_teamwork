<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Task;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TaskView extends Page
{
    public $data;

    protected static string $view = 'filament.pages.task-view';

    public function mount($id) {        
        // Use the $id parameter to fetch the task data
        $task = Task::with('users')->find($id);
        // Pass the $task data to the view
        $this->data = $task;
        $this->form->fill();
    }
     
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Textarea::make('comment')
                ->required(),
            Forms\Components\FileUpload::make('attachment'),
        ];
    }
}
