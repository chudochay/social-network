<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('query');

        if(!$query) {
            return redirect()->route('home');
        }

        $users = User::where(DB::raw("CONCAT(name, ' ', surname)"),
            'LIKE', "%{$query}%")
            ->orWhere('surname', 'LIKE', "%{$query}%")
            ->get();

        return view('search.index')->with('users', $users);
    }
}
