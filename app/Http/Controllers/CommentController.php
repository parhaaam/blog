<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('comments.index',[
          'comments' => Comment::orderBy('created_at','DESC')->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$post)
    {
      $request->validate([
        'user_name'   => 'required|string',
        'user_email'  => 'required|string|email',
        'website'     => 'string|url',
        'text'        => 'required|string',
      ]);
      Comment::create([
        'user_name'   => $request->input('user_name'),
        'user_email'  => $request->input('user_email'),
        'user_id'     => $request->user() ? $request->user()->id : 0,
        'post_id'     => $post,
        'text'        => $request->input('text'),
        'website'     => $request->input('website'),
      ]);
      return redirect()->route('single',['post'=> $post])->withErrors(new MessageBag( ['messages' => 'نظر شما ثبت شد و منتظر تایید مدیر است']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('commentsList')->withErrors(new MessageBag( ['messages' => 'نظر موردنظر شما با موفقیت حذف شد']));

    }
    /**
     * Publish specified Comment
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function submit(Comment $comment)
    {
        $comment->status = 2;
        $comment->save();
        return redirect()->route('commentsList')->withErrors(new MessageBag( ['messages' => 'نظر موردنظر شما با موفقیت منتشر شد']));

    }
    /**
     * Mark specified Comment as spam
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function spam(Comment $comment)
    {
        $comment->status = 1;
        $comment->save();
        return redirect()->route('commentsList')->withErrors(new MessageBag( ['messages' => 'نظر موردنظر شما با موفقیت اسپم شد']));

    }
}
