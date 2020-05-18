<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Post extends Model
{
    protected $fillable =[
      'title','text','status','user_id','category_id','likes','thumbnail'
    ];
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    public function category()
    {
      return $this->belongsTo(Category::class);
    }
    public function tag()
    {
      return $this->belongsToMany(Tag::class);
    }
}
