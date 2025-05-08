<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFriends extends Model
{
    use HasFactory;
    protected $table = 'user_friends';

    public function user() {
        return $this->belongsTo(User::class);
    }
}
