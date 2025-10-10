<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/teste', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::get('/user/{user}', [UserController::class, 'show'])->middleware('auth:sanctum');
Route::patch('/user/{user}', [UserController::class, 'update'])->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);
