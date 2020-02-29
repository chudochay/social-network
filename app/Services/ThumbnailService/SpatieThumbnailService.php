<?php

namespace App\Services\ThumbnailService;

use Intervention\Image\Facades\Image;

class SpatieThumbnailService implements ThumbnailServiceInterface
{

    public function make(string $path, string $name): void
    {
        $img = Image::make($path);
        $img->resize(120, 120);
        $img->save(storage_path('app/public/images/thumbnails/'.$name));
    }

//    public function setName(string $name): void
//    {
//        $this->name = $name;
//    }

}
