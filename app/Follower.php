<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $fillable = ['follow_id'];
    // user follows an other user
    // this follow belongs to the user 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
