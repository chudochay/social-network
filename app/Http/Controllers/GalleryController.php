<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index($id)
    {
        $user = User::where('id', $id)->first();
        $galleries = $user->galleries;

        return view('gallery.index')
            ->with('user', $user)
            ->with('galleries', $galleries);
    }

    public function show($gallery_id)
    {
        $gallery = Gallery::where('id', $gallery_id)->first();
        $user = User::where('id', $gallery->user_id)->first();
        $images = Image::all()->where('gallery_id', $gallery_id);
        return view('gallery.show')
            ->with('images', $images)
            ->with('gallery', $gallery)
            ->with('user', $user);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:20',
        ]);

        $user = Auth::user();

        $gallery = Gallery::create([
            'name' => ucfirst($request->input("name")),
            'user_id' => $user->id
        ]);

        $user->galleries()->save($gallery);
        return redirect()
            ->back()
            ->with('success', 'Gallery created.');
    }

    public function destroy($id)
    {
        $gallery = Gallery::find($id);
        $images = Image::all()->where('gallery_id', $id);
        foreach ($images as $image) {
            Storage::disk('public')
                ->delete([$image->image_path, $image->thumbnail_path]);
            $image->delete();
        }
        $gallery->delete();
        return redirect()->back();
    }
}
