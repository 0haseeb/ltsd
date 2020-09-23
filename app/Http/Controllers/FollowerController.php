<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Notifications\UserFollowed;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // middleware to only allow auth user access
        $this->middleware('auth');
    }

    /**
     * Follow a user
     *
     * @param  User  $user // user to be folllowed by auth user
     * @return \Illuminate\Http\Response
     */
    public function follow(User $user)
    {
        // check if auth user is not already following the user
        if (!Auth::user()->isFollowing($user->id)) {
            // Create a new follow instance for the authenticated user
            Auth::user()->follower()->create([
            'follow_id' => $user->id,
        ]);
            // fotify the user of new following
            $user->notify(new UserFollowed(Auth::user()));
            return back();
        } else {
            return back();
        }
    }

    /**
     * unfollow a user
     *
     * @param  User  $user // user to be unfolllowed by auth user
     * @return \Illuminate\Http\Response
     */
    public function unfollow(User $user)
    {
        //make sure auth user is actually followind the user
        if (Auth::user()->isFollowing($user->id)) {
            // delete follow instance for the authenticated user
            $follow = Auth::user()->follower()->where('follow_id', $user->id)->first();
            $follow->delete();
            // no need to notify user
            return back();
        } else {
            return back();
        }
    }

    /**
     * Get list of a user's ($user) followers
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function follower(User $user)
    {
        // user->followers() is a one-to-many realation between user and Follower model.
        $user_ids= $user->followers()->pluck('user_id');
        $users=User::whereIn('id', $user_ids)->orderby('created_at', 'desc')->paginate(10);
        return view('users/followers', compact('users', 'user'));
    }

    /**
     * Get list of a user's followings
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function following(User $user)
    {
        $user_ids= $user->followings()->pluck('follow_id');
        $users=User::whereIn('id', $user_ids)->orderby('created_at', 'desc')->paginate(10);
        return view('users/following', compact('users', 'user'));
    }
}
