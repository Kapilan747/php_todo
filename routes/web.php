<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', [TodoController::class, 'index']);
Route::post('/todos', [TodoController::class, 'store']);
Route::post('/todos/{todo}/toggle', [TodoController::class, 'toggle']);
Route::delete('/todos/{todo}', [TodoController::class, 'destroy']);
