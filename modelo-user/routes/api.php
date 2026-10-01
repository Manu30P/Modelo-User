<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', [UserController::class, 'index']);
Route::post('/user/create', [UserController::class, 'store']);
Route::post('/user/login', [UserController::class, 'login']);
Route::put('/user/update-username', [UserController::class, 'updateUsername']);
Route::put('/user/update-email', [UserController::class, 'updateEmail']);
Route::put('/user/update-password', [UserController::class, 'updatePassword']);
Route::delete('/user/delete', [UserController::class, 'destroy']);