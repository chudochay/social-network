<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PostController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'post'=>'required|max:1000',
        ]);

        Auth::user()->posts()->create([
            'body' => $request->input('post'),
        ]);

        return redirect()
            ->route('home');
    }

    public function comment(Request $request, $postId)
    {
        $this->validate($request, [
            "reply-{$postId}"=>'required|max:1000',
            ], [
                'required' => 'The reply body is required.'
        ]);

        $post = Post::notReply()->find($postId);

        if (!$post) {
            return redirect()->route('/');
        }

        if (!Auth::user()->isFriendsWith($post->user) && Auth::user()->id !==
            $post->user->id) {
            return redirect()->route('/');
        }

        $reply = Post::create([
            'body' => $request->input("reply-{$postId}"),
            'user_id'=> Auth::user()->id
        ]);

        $post->replies()->save($reply);

        return redirect()->back();
    }

    public function like($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return redirect()->route('/');
        }
        //only friends can put 'like (strangers and me cannot)
//        if (!Auth::user()->isFriendsWith($post->user) && Auth::user()->id !==
//            $post->user->id) {
//            return redirect()->route('/');
//        }

        if (Auth::user()->hasLikedPost($post)) {
            $like = $post->likes->where('user_id', Auth::user()->id);
            Auth::user()->likes()->delete($like);
            return redirect()->back();
        }

        $like = $post->likes()->create([
            'user_id'=> Auth::user()->id
        ]);
        Auth::user()->likes()->save($like);

        return redirect()->back();
    }
}
