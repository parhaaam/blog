<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable =[
      'text','status','post_id','user_id','user_name','user_email'
    ];
    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
