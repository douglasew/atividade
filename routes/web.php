<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('tasks')->group(function () {
    Route::controller(TaskController::class)->group(function () {
        Route::get('/', 'index')->name('task.show');
        Route::get('/create', 'create')->name('task.form');
        Route::post('/', 'store')->name('task.create');
        Route::delete('/{id}', 'destroy')->name('task.destroy');
    });
});
