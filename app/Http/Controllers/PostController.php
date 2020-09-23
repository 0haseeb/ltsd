<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\User;
use App\Tag;
use App\Notifications\PostLiked;
use App\Notifications\PostComment;
use Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display auth user's and auth users followings posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        //find ids of users auth user is following
        $user_ids= $user->followings()->pluck('follow_id')->toArray();
        //add auth user's id to list of user ids
        $user_ids[]=$user->id;
        // Get ids of all tags followed by user
        $tagsId = $user->followtag()->pluck('tag_id')->toArray();
        // Get all posts with corrensponding tag
        //find posts where user_id is $user_ids, order by latest and get 10 posts perpage.
        $posts = Post::whereHas('tags', function ($query) use ($tagsId) {
            $query->whereIn('tags.id', $tagsId);
        })->orWhereIn('user_id', $user_ids)->orderby('created_at', 'desc')->paginate(10);
        // show home page with array of posts
        return view('home', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $post validation
        $post = $this->validate(request(), [
        'content' => 'required|max:1000',
        'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:1500',
        ]);
        // create a post object and set its values from the input
        $post = new Post;
        $post->content = $request->input('content');
        $post->user_id = Auth::user()->id;
        $post->created_at = now();
        $post->has_image = 0;
        // if post has image
        if ($request->image != null) {
            //set $post->image to time().ClientOriginalExtension and move inage to public post images folder
            $imagename= time().".".$request->image->getClientOriginalExtension();
            $request->image->move('images/post', $imagename);
            $post->image=$imagename;
        }

        if ($post) {
            //where ever there is a hashtag in posts content, save the hashtag to $tagsnames.
            preg_match_all('/#(\w+)/', $post->content, $tagNames);
            $tags_ids = [];
            foreach ($tagNames[1] as $tagName) {
                $tag = Tag::firstOrCreate(['name'=>$tagName]);
                if ($tag) {
                    $tags_ids[] = $tag->id;
                }
            }
            $post->save();
            $post->tags()->withTimestamps()->sync($tags_ids);
        }
        // generate a redirect HTTP response (no success message required)
        return back();
    }

    /**
     * Show a post by given $id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $post = Post::with('comments')->find($id);
        // return view('show')->with('post', $post);
        $post = Post::find($id);
        // get $post comments adn order by latest
        $comments = $post->comments()->orderby('created_at', 'desc')->paginate(10);
        // show post/show page with post and comments array
        return view('post/show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // hangled by javescript modal
    //  $post = Post::find($id);
    //  return view('home',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //$post if passed as hidden field
        $post= Post::findOrFail($request->post_id);
        if ($post) {
            preg_match_all('/#(\w+)/', $post->content, $tagNames);
            // $tagnames contains an array of results. $tagnames[0] is all matches
            $tags_ids = [];
            foreach ($tagNames[1] as $tagName) {
                //$post->tags()->create(['name'=>$tagName]);
                //Or to take care of avoiding duplication of Tag
                //you could substitute the above line as
                $tag = Tag::firstOrCreate(['name'=>$tagName]);
                if ($tag) {
                    $tags_ids[] = $tag->id;
                }
            }
            $post->update($request->all());
            $post->tags()->withTimestamps()->sync($tags_ids);
        }
        return back()->withSuccess('Post Updated');
    }

    /**
     * Remove the post from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $post= Post::findOrFail($request->post_id);
        if ($post) {
            $post->delete();
        }
        return redirect('home')->with('success', 'Post has been deleted');
    }


    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function showComments()
    // {
    //
    // }

    /**
     * Store a newly created Comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request)
    {
        // form validation
        $comment = $this->validate(request(), [
        'comment' => 'required|max:1000',
        ]);
        // create a Comment object and set its values from the input
        $comment = new Comment;
        $comment->comment = $request->input('comment');
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->post_id;
        $comment->created_at = now();
        // save the Comment object
        $comment->save();

        // find who this post belongs to
        $post= Post::findOrFail($comment->post_id);
        $user=$post->user;
        // if user other then auth user then notify user of new comment on thier post.
        if ($user!=Auth::user()) {
            $user->notify(new PostComment(Auth::user(), $post, $comment->comment));
        }
        // generate a redirect HTTP response with a success messag
        return back();
    }

    /**
     * Remove the Comment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroycomment($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return back()->with('success', 'Comment has been deleted');
    }

    /**
     * leavea a like on a post.
     *@param $id //post_id to like
     *@return \Illuminate\Http\Response
     */
    public function like($id)
    {
        // check is post is not already like by auth user
        if (!Auth::user()->hasliked($id)) {
            // create an new like relation instance between auth user and post it id $id
            Auth::user()->likes()->create(['post_id' => $id,]);
            // find who like post belongs to
            $post= Post::findOrFail($id);
            $user=$post->user;
            // if it belongs tyo someone other then auth user then notify user.
            if ($user!=Auth::user()) {
                $user->notify(new PostLiked(Auth::user(), $post));
            }
            return back();
        } else {
            return back();
        }
    }
    public function unlike($id)
    {
        if (Auth::user()->hasliked($id)) {
            // delete like relation
            $like = Auth::user()->likes()->where('post_id', $id)->first();
            $like->delete();
            return back();
        } else {
            return back();
        }
    }
}
