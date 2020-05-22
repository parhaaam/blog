<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Post extends Model
{
    protected $fillable =[
      'title','text','status','user_id','category_id','likes','thumbnail'
    ];
    protected $append = ['likesCount'];
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    public function category()
    {
      return $this->belongsTo(Category::class);
    }
    public function tags()
    {
      return $this->belongsToMany(Tag::class);
    }
    public function comments()
    {
      return $this->hasMany(Comment::class);
    }
    public function likes()
    {
      return $this->hasMany(Likes::class);
    }
    public function getLikesCountAttribute()
    {
      return $this->likes()->get()->count();
    }


}
