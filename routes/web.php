<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('auth.login');
Route::post('/', [LoginController::class, 'authenticate'])->name('login');
Route::post('/index', [LoginController::class, 'logout'])->name('logout');

Route::get('/index', function () {
    return view('index');
})->name('index')->middleware('auth');

Route::get('/auth/register', [RegisterController::class, 'index'])->name('auth.register');
Route::post('/auth/register', [RegisterController::class, 'register'])->name('register');
