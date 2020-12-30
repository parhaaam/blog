<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Likes;
use Illuminate\Http\Request;

class LikesController extends Controller
{
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$post)
    {

        $isLiked = Likes::where('post_id',$post)->where('user_id',$request->user() != null? $request->user()->id : 0)->orWhere('user_ip',$request->ip)->get();
        if($isLiked->count() < 1){
            Likes::create([
                'post_id' => $post,
                'user_id' => $request->user() != null? $request->user()->id : 0,
                'user_ip' => $request->ip()
            ]);
        }else{
          $isLiked->map(function ($like) {
            $like->delete();
          });
        }
        return response(['messages' => 'لایک ثبت شد']);

    }

    
}
