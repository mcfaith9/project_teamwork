<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class Timer extends Page
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.timer';

    protected static ?string $title = 'Track Time';

    public $tasks;
    public $totalTimeLog;

    public function mount()
    {
        $userId = auth()->id();      
        
        //Get total timelog
        $totalTaskTimeLog = DB::table('task_time_log')->where('user_id', auth()->id())->whereDate('created_at', today())->sum('prev_time_today') ?? 0;

        $this->totalTimeLog = CarbonInterval::milliseconds($totalTaskTimeLog)->cascade()->format('%H:%I:%S');

        // Get the tasks assigned to the user with pivot time log for the current day
        $assignedTasks = Task::whereIn('id', function($query) use ($userId) {
            $query->select('task_id')
                ->from('task_user')
                ->where('user_id', $userId);
        })
        ->with(['timeLogs' => function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->whereDate('task_time_log.created_at', Carbon::today());
        }])
        ->get()
        // if there is no record for that day 
        ->map(function($task) {
            $task->prev_time_today = $task->timeLogs->isEmpty() ? 0 : $task->timeLogs;
            unset($task->timeLogs);
            return $task;
        })
        ->toArray();

        // dd($assignedTasks);

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

    public function storeTimeLog(Request $request)
    {
        \DB::table('task_time_log')->updateOrInsert(
            ['task_id' => $request->task_id, 'user_id' => $request->user_id],
            ['prev_time_today' => $request->prev_time_today, 'time_log' => $request->time_log, 'created_at' => now(), 'updated_at' => now()]
        );
    }
}
