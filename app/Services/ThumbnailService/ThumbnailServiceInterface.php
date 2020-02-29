<?php

namespace App\Services\ThumbnailService;

interface ThumbnailServiceInterface
{
    public function make(string $path, string $name): void;

//    public function setName(string $name): void;
}
