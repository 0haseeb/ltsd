<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Tag;
use Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * gets data for user profile pages
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if ($user) {
            // get users posts, sort by latest, show 10 perpage.
            $posts= $user->posts()->orderby('created_at', 'desc')->paginate(10);
            $followerscount= count($user->followers);
            $followingcount= count($user->followings);
            $Topicscount= count($user->followtag);
            $Postscount= count($user->posts);
            $Likescount= count($user->Likes);
            // Get ids of all tags followed by user
            $tag_ids= $user->followtag()->where('favorite', 1)->pluck('tag_id');
            // Get tags by id.
            $tags=Tag::whereIn('id', $tag_ids)->orderby('created_at', 'desc')->get();
            return view('users/profile', compact('user', 'posts', 'followerscount', 'followingcount', 'Topicscount', 'Postscount', 'Likescount','tags'));
        } else {
            return view('404');
        }
    }

    /**
     * gets users liked posts along with users profile page info.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function likedposts(User $user)
    {
        if (!$user==null) {
            // from user post lided relation get post_ids
            $likes = $user->likes()->pluck('post_id')->toArray();
            $likedposts = Post::whereIn('id', $likes)->orderby('created_at', 'desc')->paginate(10);
            $followerscount= count($user->followers);
            $followingcount= count($user->followings);
            $Topicscount= count($user->followtag);
            $Postscount= count($user->posts);
            $Likescount= count($user->Likes);
            // Get ids of all tags followed by user
            $tag_ids= $user->followtag()->where('favorite', 1)->pluck('tag_id');
            // Get tags by id.
            $tags=Tag::whereIn('id', $tag_ids)->orderby('created_at', 'desc')->paginate(10);
            return view('users/likes', compact('user', 'followerscount', 'followingcount', 'Topicscount', 'Postscount', 'likedposts', 'Likescount','tags'));
        } else {
            return view('404');
        }
    }

    /**
    * updates users profile information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $user= User::findOrFail($request->user_id);
        // $user->update($request->all());
        // return back();
        $user = Auth::user();
        // validation checks
        $this->validate(request(), [
      'name' => ['required', 'string', 'max:255'],
      'bio' => [ 'max:500'],
      ]);
        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->updated_at = now();
        // Stores profile image to public folder
        if ($request->image != null) {
            $imagename= time().".".$request->image->getClientOriginalExtension();
            $request->image->move('images/profile', $imagename);
            $user->image=$imagename;
        }
        $user->save();
        return back()->withSuccess('Profile Updated');
    }
    /**
     * show account settings page
     *
     * @return \Illuminate\Http\Response
     */
    public function showAccountSettings()
    {
        return view('users/accountsettings');
    }
    /**
    * updates users Account settings information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAccountSettings(Request $request)
    {
        $user = Auth::user();
        // update email
        if ($request->has('email')) {
            $this->validate(request(), [
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
      ]);
            $user->email = $request->email;
        }
        // update username
        if ($request->has('username')) {
            $this->validate(request(), [
        'username' => ['required', 'string', 'min:4', 'max:12', 'alpha_dash', 'unique:users']
      ]);
            $user->username = $request->username;
        }
        // update date of birth
        if ($request->has('dob')) {
            $this->validate(request(), [
        'dob' =>  ['required', 'before:13 years ago']
      ]);
            $user->dob = $request->dob;
        }
        $user->save();
        return back()->withSuccess('Profile Updated');
    }

    /**
     * show security settings page
     *
     * @return \Illuminate\Http\Response
     */
    public function showSecuritySettings()
    {
        return view('users/securitysettings');
    }

    /**
    * updates users Security Setings information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSecuritySettings(Request $request)
    {
        $user = Auth::user();
        $this->validate(request(), [
        'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        // check if current password 'oldpassword' maches Auth user's password.
        if (Hash::check(request('oldpassword'), auth()->user()->password)) {
            // check if 'oldpassword' is same as new password
            if (Hash::check(request('password'), auth()->user()->password)) {
                return redirect()->back()->withErrors(["Password" => "New password cannot the same as old password"]);
            } else {
                // convert password to hash
                $user->password = Hash::make($request->password);
                $user->save();
                return back()->withSuccess('Password Changed');
            }
        } else {
            return redirect()->back()->withErrors(["Incorrect Password" => "Please enter correct password"]);
        }
    }
    /**
     * Remove the post from storage.
     *
    * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (Hash::check(request('password'), auth()->user()->password)) {
            $user = User::find(Auth::user()->id);
            $user->delete();
            return redirect('home')->with('success', 'Post has been deleted');
        } else {
            return redirect()->back()->withErrors(["Password" => "Account cannot be delete: Incorrect password"]);
        }
    }
}
