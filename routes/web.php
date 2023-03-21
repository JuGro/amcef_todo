<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Todos
Route::get('/', [TodoController::class, 'index']);
Route::middleware([
        'auth',
    ])->group(function () {
        Route::get('/todos/create', [TodoController::class, 'create']);
        Route::post('/todos/store', [TodoController::class, 'store']);        
        Route::get('/todos/{todo}/edit', [TodoController::class, 'edit']);
        Route::put('/todos/{todo}', [TodoController::class, 'update']);
        Route::get('/todos/{todo}/share', [TodoController::class, 'share']);
        Route::post('/todos/{todo}/share', [TodoController::class, 'share_update']);
        Route::delete('/todos/{todo}', [TodoController::class, 'destroy']);
        Route::get('/todos/{todo}/restore', [TodoController::class, 'restore']);
        Route::post('/todos/{todo}/complete', [TodoController::class, 'complete']);
        Route::post('/todos/{todo}/reopen', [TodoController::class, 'reopen']);
        
});
Route::get('/todos/{todo}', [TodoController::class, 'show']);

// Users
Route::get('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/users', [UserController::class, 'store']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::post('/users/authenticate', [UserController::class, 'authenticate']);



