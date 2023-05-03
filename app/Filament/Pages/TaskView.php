<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Models\Comment;
use App\Models\Task;
use Filament\Forms\ComponentContainer;

class TaskView extends Page
{
    public $data;
    public $comments;
    public bool $showComments = true;
    
    protected static string $view = 'filament.pages.task-view';

    public function mount($id) {        
        // Use the $id parameter to fetch the task data
        $task = Task::with('users')->find($id);

        // Pass the $task data to the view
        $this->data = $task;
        $this->form->fill();

        // Fetch the comments for this task
        $this->comments = Comment::where('task_id', $id)->with('user')->get();
    }
     
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\RichEditor::make('comment')
                ->disableToolbarButtons([
                    'attachFiles',
                    'h2',
                    'h3',
                ]),
            Forms\Components\FileUpload::make('attachments')
                ->preserveFilenames()
                ->enableDownload()
                ->enableOpen()   
                ->multiple(),
        ];
    }

    public function refreshComments()
    {
        $id = $this->data->id;
        $this->comments = Comment::where('task_id', $id)->with('user')->get();
    }

    public function submit(): void 
    {
        $task = Task::find($this->data->id);

        $comment = new Comment([
            'body' => $this->form->getState()['comment'],
        ]);

        // Handle uploaded images
        $attachments = $this->form->getState()['attachments'];

        $attachmentPaths = [];

        foreach ($attachments as $attachment) {
            $path = Storage::disk('local')->put($attachment, 'files');
            $attachmentPaths[] = $attachment;
        }

        $comment->attachments = json_encode($attachmentPaths);
        $comment->user_id = auth()->id();
        $task->comments()->save($comment);

        $this->form->fill();
        $this->notify('success', 'Comment added successfully!');
        $this->refreshComments();       
    }
}
