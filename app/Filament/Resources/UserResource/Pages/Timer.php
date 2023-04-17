<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Task;

class Timer extends Page
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.timer';

    protected static ?string $title = 'Track Time';

    public $tasks;

    public function mount()
    {
        $userId = auth()->id();

        // Get the task ids assigned to the user
        $taskIds = DB::table('task_user')->where('user_id', $userId)->pluck('task_id')->toArray();

        // Get the tasks assigned to the user
        $assignedTasks = Task::whereIn('id', $taskIds)->get()->toArray();

        $taskSequence = DB::table('task_sequence')->where('user_id', $userId)->first();

        // If the user has not created any task sequence
        if (!$taskSequence) {
            // Return all assigned tasks as array
            $this->tasks = $assignedTasks;
            return;
        }

        // Do something with the $sequence array
        $sequence = json_decode($taskSequence->sequence);

        // Get tasks that are in the sequence
        $tasksInSequence = collect([]);

        foreach ($sequence as $taskId) {
            $task = collect($assignedTasks)->firstWhere('id', $taskId);

            if ($task) {
                $tasksInSequence->push($task);
            }
        }

        // Get tasks that are not in the sequence
        $tasksNotInSequence = collect($assignedTasks)->reject(function ($task) use ($tasksInSequence) {
            return $tasksInSequence->contains('id', $task['id']);
        });

        // If all tasks are already in the sequence
        if ($tasksNotInSequence->isEmpty()) {
            // Return tasks that are in the sequence
            $this->tasks = $tasksInSequence->toArray();
            return;
        }

        // If there are tasks that are not in the sequence
        // Return all tasks that are in the sequence and not in the sequence
        $this->tasks = $tasksInSequence->merge($tasksNotInSequence)->toArray();
    }

    public function storeSequence(Request $request)
    {
        $user = $request->user();

        // Get the sequence from the request
        $sequence = $request->input('sequence');

        // Save the sequence for the current user
        DB::table('task_sequence')->updateOrInsert(
            ['user_id' => $user->id],
            ['sequence' => json_encode($sequence)]
        );
    }
}
