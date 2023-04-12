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
        $taskSequence = DB::table('task_sequence')
                        ->where('user_id', $userId)
                        ->first();

        if ($taskSequence) {
            $sequence = json_decode($taskSequence->sequence);
            $this->tasks = Task::whereIn('id', $sequence)->orderByRaw('FIELD(id, '.implode(',', $sequence).')')->get()->toArray();
            // do something with the $sequence array
        } else {
            $this->tasks = Task::all()->toArray();
        }
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
