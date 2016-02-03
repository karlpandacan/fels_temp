<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Http\Requests;

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
        $user = auth()->user();
        $followingIds = $user->followers()->lists('follows.follower_id');
        $followingIds->push($user->id);
        $activities = Activity::userIds($followingIds)->latest()->paginate(15);
        $activities->load('user');
        $learnedWords = $user->learnedWords()->count();
        $followers = $user->followees()->count();
        $following = $user->followers()->count();
        return view('home')
            ->with('activities', $activities)
            ->with('followers', $followers)
            ->with('following', $following)
            ->with('words', $learnedWords);
    }
}
