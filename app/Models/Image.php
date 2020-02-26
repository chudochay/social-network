<?php

namespace App\Models;

use App\Album;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = [
        'name', 'album_id', 'path'
    ];

    public function album(){
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
