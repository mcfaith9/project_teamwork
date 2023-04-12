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

    public $tasks;

    public function mount()
    {        
        $userId = auth()->id();
        $taskSequence = DB::table('task_sequence')->where('user_id', $userId)->first();

        // If the user has not created any task sequence
        if (!$taskSequence) {
            // Return all tasks as array
            $this->tasks = Task::all()->toArray();
            return;
        }

        // Do something with the $sequence array
        $sequence = json_decode($taskSequence->sequence);

        // Get tasks that are in the sequence
        $tasksInSequence = Task::whereIn('id', $sequence)->orderByRaw('FIELD(id, '.implode(',', $sequence).')');

        // Get tasks that are not in the sequence
        $tasksNotInSequence = Task::whereNotIn('id', $sequence);

        // If all tasks are already in the sequence
        if (!$tasksNotInSequence->exists()) {
            // Return tasks that are in the sequence
            $this->tasks = $tasksInSequence->get()->toArray();
            return;
        }

        // If there are tasks that are not in the sequence
        // Return all tasks that are in the sequence and not in the sequence
        $this->tasks = $tasksInSequence->union($tasksNotInSequence)->get()->toArray();
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
