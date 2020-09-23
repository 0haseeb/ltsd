<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'dob','username', 'email', 'password', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // user can have many posts
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    // user can like many posts
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
    // check if user has like the post with given id
    public function hasliked($post_id)
    {
        return (bool)$this->likes()->where('post_id', $post_id)->first(['id']);
    }
    // user can comment on many posts
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    // User has many followers
    public function follower()
    {
        return $this->hasMany('App\Follower');
    }
    /**
     * return list of user followings
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follow_id')->withTimestamps();
    }
    /**
     * return list of user followers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follow_id', 'user_id')->withTimestamps();
    }
    // retun true is Auth user is following $follow_id
    public function isFollowing($follow_id)
    {
        return (bool)$this->follower()->where('follow_id', $follow_id)->first(['id']);
    }
    //User tags followings
    public function followtag()
    {
        return $this->hasMany('App\Followtag');
    }
    // check if Auth user is following $tag_id
    public function isFollowingtag($tag_id)
    {
        return (bool)$this->followtag()->where('tag_id', $tag_id)->first(['id']);
    }
    public function isFavoritetag($tag_id)
    {
        return (bool)$this->followtag()->where('tag_id', $tag_id)->where('favorite', 1)->first(['id']);

    }

    // user name as route
    // show user name in url instead of user id
    public function getRouteKeyName()
    {
        return 'username'; // db column name
    }
}
