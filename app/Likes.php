<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $fillable = [
      'post_id','user_id','user_ip'
    ];
    public function post()
    {
      return $this->belongsTo(Post::class);
    }
    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
