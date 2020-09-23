<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];
    // one post belongs to many tags
    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }
    // show tags names in url instead of tag ids
    public function getRouteKeyName()
    {
        return 'name';
    }
    public function setNameAttribute ($name){
    // tags names are set to lower case (tags are case insenstive)
    $this->attributes['name'] = strtolower($name);
}
}
