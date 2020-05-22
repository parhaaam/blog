<?php

namespace App\Http\Controllers;

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
        return View('tag.index',[
          'tags' => Tag::paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return View('tag.create');
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
      return redirect()->route('tagList')->withErrors(new MessageBag( ['messages' => 'هشتگ شما با موفقیت ثبت شد']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
      return View('tag.edit',[
        'tag' => $tag
      ]);
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
      return redirect()->route('tagList')->withErrors(new MessageBag( ['messages' => 'هشتگ با موفقیت ویرایش شد']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
      $tag->post()->detach();
      $tag->delete();
      return redirect()->route('tagList')->withErrors(new MessageBag( ['messages' => 'هشتگ با موفقیت حذف شد']));

        //

    }
}
