<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\Page;
use App\Models\Task;

class MyWork extends Page
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.my-work';

    public $taskWork;

    public function mount() {
        $userId = auth()->id();

        // Check if the authenticated user has a superadmin role
        if(auth()->user()->roles->pluck('name')->contains('super_admin')) {
            $this->taskWork = Task::get(); // Get all tasks
            return;
        }

        // Otherwise, get tasks assigned to the authenticated user
        $this->taskWork = Task::whereRaw('JSON_CONTAINS(assignee_id, \'["' . $userId . '"]\')')->get();
    }
}
