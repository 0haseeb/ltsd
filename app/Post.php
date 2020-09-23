<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = ['content'];
    // posts belongs to user
    public function user(){
        return $this->belongsTo('App\User');
    }
    // post can have many comments
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    // post can have many likes
   public function likes(){
       return $this->hasMany('App\Like');
    }
    // posts can have many tags
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
