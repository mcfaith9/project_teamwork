<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\UserResource\Pages\Timer;
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

// Store Task Sequence
Route::post('/tasks/store-sequence', [Timer::class, 'storeSequence'])
    ->name('timer.store-sequence')
    ->middleware(['auth']);
