<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Tag;
use Auth;

class SearchController extends Controller
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
    * Handles search requests for posts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findPosts(Request $request)
    {
        $q = $request->search;
        // find post where post content maches search query
        $posts = Post::where('content', 'LIKE', '%'.$q.'%')->paginate(10);
        $posts->appends(['search' => $q]);
        return view('search/posts', compact('posts', 'q'));
    }
    /**
     * Handles search requests for users accounts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findUsers(Request $request)
    {
        $q = $request->search;
        // find users where username, name or user's bio maches search query
        $users = User::where('username', 'LIKE', '%'.$q.'%')->orWhere('name', 'LIKE', '%'.$q.'%')->orWhere('bio', 'LIKE', '%'.$q.'%')->paginate(10);
        $users->appends(['search' => $q]);
        return view('search/users', compact('users', 'q'));
    }
    /**
     * Handles topics search requests
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findTags(Request $request)
    {
        $q = $request->search;
        // find tags where tag names maches search query
        $tags = Tag::where('name', 'LIKE', '%'.$q.'%')->paginate(10);
        $tags->appends(['search' => $q]);
        return view('search/tags', compact('tags', 'q'));
    }
}
