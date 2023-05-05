<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\UserResource\Pages\Timer;
use App\Filament\Pages\TaskView;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/app/tasks/{id}', TaskView::class)
    ->name('tasks.show')
    ->middleware(['auth']);

Route::post('/task-attribute/update-date-range', [TaskView::class, 'storeSelectedDateRange'])
    ->name('task.attribute.store-date-range')
    ->middleware(['auth']);

Route::post('/tasks/store-sequence', [Timer::class, 'storeSequence'])
    ->name('timer.store-sequence')
    ->middleware(['auth']);

Route::post('/task_time_log', [Timer::class, 'storeTimeLog'])
    ->name('task_time_log.store')
    ->middleware(['auth']);



