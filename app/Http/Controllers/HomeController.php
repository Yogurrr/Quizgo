<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Set;
use App\Models\Card;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return view('home/index');
    }

    public function quizgo(Request $request) 
    {
        $sets = Set::get();
        $number_of_cards = Card::select('set_title', DB::raw('count(*) as count'))
                            ->groupBy('set_title')->orderBy('created_at')->get();

        $userinfo = User::select('email', 'name', 'profile')->get();

        return view('home/quizgo', compact('sets', 'number_of_cards', 'userinfo'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        if($search) {
            $searched_sets = Set::where('title', 'like', "%$search%")->get();
            $searched_users = User::where('name', 'like', "%$search%")->get();
        }

        $number_of_cards = Card::select('set_title', DB::raw('count(*) as count'))
                            ->groupBy('set_title')->orderBy('created_at')->get();

        $userinfo = User::select('email', 'name', 'profile')->get();

        $number_of_sets = Set::select('email', DB::raw('count(*) as count'))
                            ->groupBy('email')->get();

        return view('home/search', compact('search', 'searched_sets', 'searched_users', 'number_of_cards', 'userinfo', 'number_of_sets'));
    }
}