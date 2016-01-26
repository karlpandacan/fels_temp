<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\LearnedWord;
use App\Http\Requests;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        $followingIds = $user->followers()->lists('follows.follower_id');
        $followingIds->push($user->id);
        $activities = Activity::whereIn('user_id', $followingIds)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        $activities->load('user');
        $learnedWords = $user->learnedWords()->count();
        return view('home')
            ->with('activities', $activities)
            ->with('words', $learnedWords);
    }
}
