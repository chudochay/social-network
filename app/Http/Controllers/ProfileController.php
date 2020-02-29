<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function show($id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            abort(404);
        }

        $posts = $user->posts()->notReply()->get();

        return view('profile.show')
            ->with('user', $user)
            ->with('posts', $posts)
            ->with('authUserIsFriend', Auth::user()->isFriendsWith($user));
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'file' =>
                'mimetypes:image/png,
                image/bmp,image/jpeg,image/jpg|
                max:8000',
            'name' => 'required|alpha|max:50',
            'surname' => 'required|alpha|max:50',
            'email' => 'required|email|max:50',
            'phone_number' => 'nullable|alpha_dash|max:50',
            'biography' => 'nullable|max:200',
            'birthday' => 'nullable|date|after_or_equal:"1920-01-01 00:00:00"',
        ]);
        $file = $request->file;
        $path = 'images/profile_pictures/';
        Storage::put($path, $file);
        $id = Auth::user()->id;
        $user = User::find($id);
        Storage::disk('public')->delete($user->profile_picture_location);
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->biography = $request->input('biography');
        $user->birthday = $request->input('birthday');
        $user->profile_picture_location = $path . "" . $file->hashName();
        $user->save();

        return redirect()
            ->route('profile.edit', [Auth::user()->id, Auth::user()->username])
            ->with('info', 'Your profile has been updated');
    }

}
