<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





Route::middleware('auth:sanctum')->group(function () {

    Route::controller(TeamController::class)->group(function () {
        Route::post('/teams/create',  'store');
        Route::get('/teams/{team}', 'show');
        Route::get('/teams',  'index');
        Route::delete('/teams/{team}/leave', 'leaveTeam');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users/unassigned',  'getAvaliablePlayers');
        Route::get('/users', 'index');
        Route::get('/users/{user}',  'show');
        Route::patch('/users/{user}',  'update');
        Route::delete('/users/{user}',  'delete');
    });
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
