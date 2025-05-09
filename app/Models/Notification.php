<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = [];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
