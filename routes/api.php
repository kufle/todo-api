<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\TodoItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('todos', [TodoController::class, 'index']);
    Route::post('todos', [TodoController::class, 'store']);
    Route::get('todos/{todo}', [TodoController::class, 'show']);
    Route::put('todos/{todo}', [TodoController::class, 'update']);
    Route::delete('todos/{todo}', [TodoController::class, 'destroy']);

    Route::get('todos/{todo}/items', [TodoItemController::class, 'index']);
    Route::post('todos/{todo}/items', [TodoItemController::class, 'store']);
    Route::get('todos/{todo}/items/{item}', [TodoItemController::class, 'show']);
    Route::put('todos/{todo}/items/{item}', [TodoItemController::class, 'update']);
    Route::delete('todos/{todo}/items/{item}', [TodoItemController::class, 'destroy']);
    Route::put('todos/{todo}/items/{item}/updateCheck', [TodoItemController::class, 'updateCheck']);
});

Route::post('auth/register', RegisterController::class);
Route::post('auth/login', LoginController::class);
