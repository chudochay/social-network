<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{

    public function getProfile($id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            abort(404);
        }

        $posts = $user->posts()->notReply()->get();

        return view('profile.index')
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
//            'profile_picture' =>
//                'mimetypes:image/png,
//                image/bmp,image/jpeg,image/jpg|
//                size:2000',
            'name' => 'required|alpha|max:50',
            'surname' => 'required|alpha|max:50',
            'email' => 'required|email|max:50',
            'phone_number' => 'nullable|alpha_dash|max:50',
            'biography' => 'nullable|max:200',
            'birthday' => 'nullable|date|after_or_equal:"1920-01-01 00:00:00"',
        ]);

        //-----------------Update Profile picture
//// Controller method
//        $fileModel = File::whereId($id)->first();
//
//// Delete the file if we have one
//        if ($fileModel->filename) {
//            FileFacade::delete(public_path('files/' . $fileModel->filename));
//        }
//
////
//        $file = $request->file('filename');
//        $clientName = $file->getClientOriginalName();
//        $path = $file->move(public_path('files'), $clientName);
//
//        $fileModel->update(['filename' => $clientName]);
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->biography = $request->input('biography');
        $user->birthday = $request->input('birthday');
        $user->save();

        return redirect()
            ->route('profile.edit', [Auth::user()->id, Auth::user()->username])
            ->with('info', 'Your profile has been updated');
    }

}
