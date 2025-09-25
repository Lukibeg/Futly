<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamJoinRequestController;


Route::get('/', function () {
    return view('dashboard');
})->name('dashboard')->middleware(middleware: 'auth');

Route::get('/login', function () {
    return view('login');
})->name('login')->middleware(middleware: 'guest');

Route::get('/register', function () {
    return view('register');
})->name('register')->middleware(middleware: 'guest');

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');


Route::middleware(['auth'])->group(function () {

    Route::resource('/users', UserController::class)->names('users');
    Route::resource('/teams', TeamController::class)->names('teams');
    Route::get('/teams/manage', [TeamJoinRequestController::class, 'index'])->name('manage');
    Route::get('/teams/{team}/join', [TeamJoinRequestController::class, 'requestJoinTeam'])->name('requestJoinTeam');
    Route::post('/teams/{joinRequest}/join', [TeamJoinRequestController::class, 'responseJoinRequest'])->name('responseJoinRequest');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
