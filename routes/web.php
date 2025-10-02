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

    Route::get('/teams/manage', [TeamJoinRequestController::class, 'index'])->name('manage');
    Route::resource('/users', UserController::class)->names('users');
    Route::resource('/teams', TeamController::class)->names('teams');
    Route::post('/teams/{team}/invite', [TeamJoinRequestController::class, 'invitePlayerToTeam'])->name('invitePlayerToTeam');
    Route::get('/teams/{team}/users', [TeamController::class, 'show'])->name('teamsUsers');
    Route::get('/teams/{team}/join', [TeamJoinRequestController::class, 'requestJoinTeam'])->name('requestJoinTeam');
    Route::post('/teams/{joinRequest}/join', [TeamJoinRequestController::class, 'responseJoinRequest'])->name('responseJoinRequest');
    Route::delete('/teams/{team}/leave', [TeamController::class, 'leaveTeam'])->name('leaveTeam');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserController::class, 'show'])->name('profile');
    Route::put('/profile/{user}', [UserController::class, 'updateProfile'])->name('profile.update');
});
