<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Image;
use App\Services\ThumbnailService\ThumbnailServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * @var ThumbnailServiceInterface
     */
    private $thumbnailService;

    public function __construct(ThumbnailServiceInterface $thumbnailService)
    {
        $this->thumbnailService = $thumbnailService;
    }

    public function store(Request $request, Gallery $gallery)
    {
        if ($request->hasfile('file')) {
            $this->validate($request, [
                'file' => 'required|mimes:jpg,jpeg,png,gif|max:8000'
            ]);
            $file = $request->file;
            Storage::put('images/originals', $file);
            $this->thumbnailService
                ->make(public_path(
                    'storage/images/originals/'.$file->hashName()), 'th_'.$file->hashName()
                );
            $image = Image::create([
                'image_path' => 'images/originals/'.$file->hashName(),
                'thumbnail_path' => 'images/thumbnails/th_'.$file->hashName(),
                'gallery_id' => $gallery->id,
            ]);
            $gallery->images()->save($image);
            return back();
        }
        return back()->with('error', 'Please try again later.');
    }

    public function destroy($gallery_id)
    {
        $image = Image::where('gallery_id', $gallery_id)->first();
        Storage::disk('public')->delete([
            $image->image_path,$image->thumbnail_path
        ]);
        $image->delete();
        return redirect()->back();
    }
}

