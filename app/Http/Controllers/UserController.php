<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follow;
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
        $user = User::findOrFail(\Auth::user()->id);
        return view('users.view')->with('user', $user);
    }

    public function search(Request $request)
    {
        $wildcard = $request->q;
        $user = \Auth::user();
        $notFollowing = User::whereNotIn('id', $user->followers()->lists('follows.follower_id'))
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

}
