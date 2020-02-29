<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    public function users() {
        return $this->belongsToMany(
            User::class,
            'user_friends',
            'user_id',
            'friend_id'
        );
    }
}
