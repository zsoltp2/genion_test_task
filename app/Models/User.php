<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'is_admin'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function friends(): HasMany {
        return $this->hasMany(UserFriends::class, 'user_id');
    }

    public function friendOf()
    {
        return $this->hasMany(UserFriends::class, 'friend_id');
    }

    public function scopeUnaccepted($query) {
        return $query->where('is_accepted_request', false);
    }

    public function sentRequests()
    {
        return $this->hasMany(UserFriends::class, 'user_id');
    }

    public function receivedRequests()
    {
        return $this->hasMany(UserFriends::class, 'friend_id')->where('status', 'sent');
    }

}
