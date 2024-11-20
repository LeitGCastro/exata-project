<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('dashboard');
    Route::get('/tasks/{task_id}', [TaskController::class, 'taskForm'])->name('task.form');
    Route::post('/tasks', [TaskController::class, 'store'])->name('task.store');
    Route::put('/tasks', [TaskController::class, 'update'])->name('task.update');
    Route::put('/tasks/status', [TaskController::class, 'updateStatus'])->name('task.updatestatus');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
