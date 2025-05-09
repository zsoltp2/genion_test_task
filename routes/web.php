<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserFriendsController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LoginController::class, 'index'])->name('auth.login');
Route::post('/', [LoginController::class, 'authenticate'])->name('login');
Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
Route::post('/index', [LoginController::class, 'logout'])->name('logout');

Route::get('/friends', [UserFriendsController::class, 'friends'])->name('friends');

Route::get('/index', function () {
    return view('index');
})->name('index')->middleware('auth');

Route::get('/auth/register', [RegisterController::class, 'index'])->name('auth.register');
Route::post('/auth/register', [RegisterController::class, 'register'])->name('register');


Route::get('/notifications/markAsRead', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('notifications.markAsRead');
Route::post('/notification/{id}/read', [NotificationController::class, 'read'])->name('notification.read');

Route::patch('/approve-user/{user}', [RegisterController::class, 'approve'])->name('user.approve');

Route::post('friend-request/{user}', [UserFriendsController::class, 'friendsRequests'])->name('user.sendRequest');
Route::patch('friend-request/{friendRequest}/accept', [UserFriendsController::class, 'acceptFriendRequest'])->name('user.acceptRequest');
Route::patch('friend-request/{friendRequest}/reject', [UserFriendsController::class, 'rejectFriendRequest'])->name('user.rejectRequest');

