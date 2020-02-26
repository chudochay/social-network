<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function foo\func;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::notReply()->where(function ($query) {
            return $query->where('user_id', Auth::user()->id)
                ->orWhereIn('user_id', Auth::user()->friends()->pluck('id'));
        })->orderBy('created_at', 'desc')
            ->get();
        return view('home')->with('posts', $posts);
    }
}
