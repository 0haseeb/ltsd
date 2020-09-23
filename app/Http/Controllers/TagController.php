<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Post;
use App\User;

class TagController extends Controller
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
     * show a spicific tag with crocponding posts.
     *
     * @param  Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //get postids where tag_id is $tag
        $post_ids= $tag->posts()->pluck('post_id')->toArray();
        //get posts with posts IDs $post_ids
        $posts =Post::whereIn('id', $post_ids)->orderby('created_at', 'desc')->paginate(10);
        return view('tags/show', compact('posts', 'tag'));
    }
    /**
     * gets a lists of tags user is following
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function usertags(User $user)
    {
        // Get ids of all tags followed by user
        $tag_ids= $user->followtag()->pluck('tag_id');
        // Get tags by id.
        $tags=Tag::whereIn('id', $tag_ids)->get();
        return view('tags/usertags', compact('user', 'tags'));
    }
}
