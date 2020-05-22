<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable =[
      'text','status','post_id','user_id','user_name','user_email','website'
    ];
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    public function post()
    {
      return $this->belongsTo(Post::class);
    }
    public function GetUpdatedAtAttribute($value)
    {
        $date = date('Y/m/d/h:s',strtotime($value));
        $date = explode('/',$date);
        $time = $date[3];
        $date = \Morilog\Jalali\CalendarUtils::toJalali($date[0],$date[1],$date[2]);
        return $date = $time." - ".implode('/', $date);
    }
}
