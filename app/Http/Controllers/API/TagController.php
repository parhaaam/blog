<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tag::orderBy('created_at','DESC')->paginate(15);
        
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'name' => 'required|string',
        'slug' => 'required|string|unique:tags'
      ]);
      $tag = Tag::create($request->all());
      return response(['messages' => 'هشتگ شما با موفقیت ثبت شد']);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
      $request->validate([
        'name' => ['required','string'],
        'slug' => ['required','unique:tags,slug,'.$tag->id,'string']
      ]);
      $tag->name = $request->input('name');
      $tag->slug = $request->input('slug');
      $tag->save();
      return response(['messages' => 'هشتگ با موفقیت ویرایش شد']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
      $tag->posts()->detach();
      $tag->delete();
      return response(['messages' => 'هشتگ با موفقیت حذف شد']);

        //

    }
}
