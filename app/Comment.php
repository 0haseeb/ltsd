<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $table = 'comments';
  protected $dates = [
      'created_at',
      'updated_at'
  ];
 // comment blongs to user
  public function user(){
      return $this->belongsTo('App\User');
  }
  // comments belongs to a post.
  public function post(){
      return $this->belongsTo('App\Post');
  }
}
