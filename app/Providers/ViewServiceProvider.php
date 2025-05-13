<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\User;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $notifications = [];

            if (Auth::check()) {
                $notifications = Auth::user()->unreadNotifications;
            }

            $view->with('notifications', $notifications);
        });
    }
}