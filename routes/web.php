<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;

// auth routes

Route::middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/loginsubmit', [AuthController::class, 'loginsubmit'])->name('loginsubmit');
});



// middleware verification
Route::middleware([CheckIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('index');
    Route::get('/newNote', [MainController::class, 'newNote'])->name('newNote');

    // edit note
    Route::get('/editNote/{id}', [MainController::class, 'editNote'])->name('edit');

    // delete note
    Route::get('/deleteNote/{id}', [MainController::class, 'deleteNote'])->name('delete');


    // logout

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
