<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follow;
use App\Models\Activity;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        return view('users.index')->with('user', $user);
    }

    public function search(Request $request)
    {
        $wildcard = $request->q;
        $user = \Auth::user();
        $notFollowing = User::whereNotIn('id',
            $user->followers()->lists('follows.follower_id'))
            ->where('id', '<>', $user->id)
            ->where(function ($query) use ($wildcard) {
                $query->where('name', 'like', '%' . $wildcard . '%')
                    ->orwhere('email', 'like', '%' . $wildcard . '%');
            })
            ->get();
        $following = $user->followers()
            ->where(function ($query) use ($wildcard) {
                $query->where('name', 'like', '%' . $wildcard . '%')
                    ->orwhere('email', 'like', '%' . $wildcard . '%');
            })
            ->get();
        return view('users.search')
            ->with('usersFollowing', $following)
            ->with('usersNotFollowing', $notFollowing);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $activities = $user->activities()
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        $learnedWords = $user->learnedWords()->count();
        if (\Auth::user()->id == $id) {
            $follow = 'self';
        } else {
            $follow = \Auth::user()->followers()->where('follower_id', $id)->exists();
            $follow = $follow ? 'following' : 'not following';
        }
        return view('users.view')
            ->with('activities', $activities)
            ->with('follow', $follow)
            ->with('user', $user)
            ->with('learnedWords', $learnedWords);
    }

}
