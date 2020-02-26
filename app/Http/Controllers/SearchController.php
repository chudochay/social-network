<?php

namespace App\Http\Controllers;
use DB;
use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function getResults(Request $request)
    {
        $query = $request->input('query');

        if(!$query) {
            return redirect()->route('home');
        }

        $users = User::where(DB::raw("CONCAT(name, ' ', surname)"), 'LIKE', "%{$query}%")
            ->orWhere('surname', 'LIKE', "%{$query}%")
            ->get();

        return view('search.results')->with('users', $users);
    }
}
