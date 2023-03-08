<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/update-profile', [UserController::class, 'updateProfile']);
    Route::get('/users', [UserController::class, 'users']);
    Route::delete('/user/{id}', [UserController::class, 'delete']);
    Route::post('/user/{id}', [UserController::class, 'update']);
    Route::post('/logout', [UserController::class, 'logout']);
});
