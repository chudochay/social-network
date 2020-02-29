<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = [
        'name', 'gallery_id', 'image_path', 'thumbnail_path'
    ];

    public function gallery(){
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
