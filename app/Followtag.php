<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Followtag extends Model
{
    protected $fillable = ['tag_id'];
    // user follows a tag, tagfollow belongs to the user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
