<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::patch('tasks/{taskId}/update-status', [TaskController::class, 'updateStatus']);

Route::resources([
    'tasks' => TaskController::class,
]);
