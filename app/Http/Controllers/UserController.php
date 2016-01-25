<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests;
use Session;
use Exemption;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        try {
            $user = new User;
            $user->avatar = $user->uploadImage($request);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
        } catch (Exception $e) {
            Session::flash('flash_error', 'Adding of User failed.');
        }

        return redirect('/user/search');
    }

    public function show(User $user)
    {
        $activities = $user->activities()
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        $learnedWords = $user->learnedWords()->count();
        if (\Auth::user()->id == $user->id) {
            $follow = 'self';
        } else {
            $follow = \Auth::user()->followers()->where('follower_id',
                $user->id)->exists();
            $follow = $follow ? 'following' : 'not following';
        }
        return view('users.view')
            ->with('activities', $activities)
            ->with('follow', $follow)
            ->with('user', $user)
            ->with('learnedWords', $learnedWords);
    }

    public function edit(User $user)
    {
        return view('users.edit')->with('user', $user);
    }

    public function update(Request $request, User $user)
    {
        try {
            $this->validate($request, [
                'name' => 'required|max:255'
            ]);
            $user->avatar = $user->uploadImage($request);
            $user->name = $request->name;
            $user->save();
            Session::flash('flash_success', 'Update successful!');
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error',
                'Update failed. The word you are trying to update cannot be found.');
        }

        return redirect()->back();
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            Session::flash('message_success', 'Delete successful!');
        } catch (ModelNotFoundException $e) {
            Session::flash('message_failed',
                'Delete failed. The word you are trying to delete cannot be found.');
        }
        return redirect('/user/search');
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

    public function updatePassword(Request $request, User $user)
    {
        try {
            $this->validate($request, [
                'password' => 'required|confirmed|min:6'
            ]);
            $user->password = bcrypt($request->password);
            $user->save();
            Session::flash('flash_success', 'Update Password    successful!');
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error',
                'Update Unsuccessful Please Try Again.');
        }
        return redirect()->back();
    }
}
