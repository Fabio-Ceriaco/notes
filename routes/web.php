<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// auth routes

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/loginsubmit', [AuthController::class, 'loginsubmit'])->name('loginsubmit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
