<?php
namespace App\Providers;

use App\Models\User;
use App\Notifications\LoginNotification;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Login::class => [
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

        Event::listen(Login::class, function ($event) {
            $user = $event->user;

            if ($user && Auth::check()){
            $user->notify(new LoginNotification());
            }
        });
    }
}
