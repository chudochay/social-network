<?php

namespace App\Models;

use App\Album;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{

    protected $table = 'galleries';
    protected $fillable = [
        'name','user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'album_id');
    }

}
