<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class FriendController extends Controller
{
    public function getIndex()
    {
        $friends = Auth::user()->friends();
        $requests = Auth::user()->friendRequests();
        return view('friends.index')
            ->with('friends', $friends)
            ->with('requests', $requests);


    }

    public function getAdd($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()
                ->route('home')
                ->with('danger', 'That user could not be found' . $username);
        }

        if (Auth::user()->id === $user->id) {
            return redirect()->route('home');
        }

        if (Auth::user()->hasFriendRequestPending($user) ||
            $user->hasFriendRequestPending(Auth::user())) {
            return redirect()
                ->route('profile.index', ['id' => $user->id, 'username' => $user->username])
                ->with('danger', 'Friend request already pending.');
        }

        if (Auth::user()->isFriendsWith($user)) {
            return redirect()
                ->route('profile.index', ['id' => $user->id, 'username' => $user->username])
                ->with('danger', 'You are already friends.');
        }

        Auth::user()->addFriend($user);

        return redirect()
            ->route('profile.index', ['id' => $user->id, 'username' => $username])
            ->with('success', 'Friend request sent.');

    }

    public function getAccept($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()
                ->route('home')
                ->with('danger', 'That user could not be found');
        }

        if (!Auth::user()->hasFriendRequestReceived($user)) {
            return redirect()->route('home');
        }

        Auth::user()->acceptFriendRequest($user);

        return redirect()
            ->route('profile.index', ['id' => $user->id, 'username' => $username])
            ->with('success', 'Friend request accepted.');
    }

    public function postDelete($username)
    {
        $user = User::where('username', $username)->first();

        if (!Auth::user()->isFriendsWith($user)) {
            return redirect()
                ->back();
        }

        Auth::user()->deleteFriend($user);
        return redirect()
            ->back()
            ->with('success', 'Friend deleted.');
    }
}
