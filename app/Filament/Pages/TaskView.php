<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\ComponentContainer;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Comment;
use App\Models\Task;

class TaskView extends Page
{
    public $comments;
    public bool $showComments = true;
    public int $progressValue = 0;

    protected static string $view = 'filament.pages.task-view';

    protected function getHeading(): string
    {
        return 'View Task';
    }     

    public function mount($id) {        
        // Pass the $task data to the view        
        $this->task = Task::with('users','subtasks')->find($id);
        $this->tag = $this->task->attribute()->pluck('tag')->first() ?? '';
        $this->form->fill();

        // Fetch the comments for this task
        $this->comments = Comment::where('task_id', $this->task->id)->with('user')->get();
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
        $id = $this->task->id;
        $this->comments = Comment::where('task_id', $id)->with('user')->get();
    }

    public function submit(): void 
    {
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
        $this->task->comments()->save($comment);

        $this->form->fill();
        $this->notify('success', 'Comment added successfully!');
        $this->refreshComments();       
    }

    public function selectedTaskFlag($value)
    {
        $taskAttributeData = [
            'flag' => $value,
        ];
        
        $this->task->attribute()->updateOrCreate([], $taskAttributeData);
        $this->notify('success', 'Flag set to '. $value);
    }

    public function selectedProgressValue()
    {
        $taskAttributeData = [
            'progress' => $this->progressValue,
        ];  

        $this->task->attribute()->updateOrCreate([], $taskAttributeData);    
        $this->notify('success', 'Progress set to '.$this->progressValue.'%');  
        $this->redirect(route('tasks.show', $this->task->id));  
    }    

    public function selectedReminder($text, $date_value)
    {
        $taskAttributeData = [
            'reminder' => $date_value,
        ];
        
        $this->task->attribute()->updateOrCreate([], $taskAttributeData);
        $this->notify('success', 'Reminder set to '.$text);
        $this->redirect(route('tasks.show', $this->task->id));
    }

    public function storeEstimateTime(string $estimateTime)
    {
        $taskAttributeData = [
            'estimate' => $estimateTime,
        ];
        
        $this->task->attribute()->updateOrCreate([], $taskAttributeData);
        $this->notify('success', 'Estimated time '.$estimateTime);
    }

    public function attachSelectedTag(string $tag)
    {
        $taskAttributeData = [
            'tag' => $tag,
        ];
        
        $this->task->attribute()->updateOrCreate([], $taskAttributeData);
        $this->notify('success', 'Tag  '.$tag.' Successfully attached');
    }

    public function storeSelectedDateRange(string $start, string $end)
    {
        $taskAttributeData = [
            'start_date' => $start,
            'due_date' => $end,
        ];        
        
        $this->task->attribute()->updateOrCreate([], $taskAttributeData); 
        $this->notify('success', 'Start Date and Due Date save successfully');
    }
}
