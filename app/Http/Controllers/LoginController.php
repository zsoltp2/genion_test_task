<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFriends;
use App\Notifications\FriendRequestNotification;
use App\Notifications\LoginNotification;
use App\Notifications\RegisterNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index() {
        if (Auth::check()) {
            return redirect()->route('index');
        }
        return view('auth.login');
    }

    public function dashboard() {
        $notifications = auth()->user()->unreadNotifications()->take(5)->get();
        $registered_users = [];
        $approved_users = [];

        if (auth()->user()->is_admin) {
            $registered_users = User::where('is_accepted_request', false)->get();
            $approved_users = User::where('is_accepted_request', true)->get();
        }

        return view('dashboard', [
            'notifications' => $notifications,
            'registered_users' => $registered_users,
            'approved_users' => $approved_users,
        ]);
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();


        if (User::where('is_accepted_request', false)->exists()) {
            $admin = User::where('is_admin', true)->first();
            $admin->notify(new RegisterNotification());
        }


        if (!$user) {
            return back()->withErrors([
                'email' => 'The provided email does not match our records.',
            ])->onlyInput('email');
        }

        if (!$user->is_accepted_request) {
            return back()->withErrors([
                'email' => 'An Admin has not yet activated your account.',
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'The provided password does not match our records.',
            ])->onlyInput('email');
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            if (UserFriends::where('friend_id', $user->id)->exists()) {
                $user->notify(new FriendRequestNotification());
            }

            return redirect()->route('index');
        }


        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }



    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}
