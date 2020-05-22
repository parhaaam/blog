<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('posts.index',[
          'posts' => Post::orderBy('updated_at','DESC')->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return View('posts.create',[
        'categories' => Category::all()
      ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user = $request->user();
      $request->validate([
        'title'       => 'required|string',
        'category'    => 'required|integer',
        'tags'        => 'string',
        'text'        => 'required|string',
      ]);
      $post = new Post();
      if($request->hasFile('thumbnail')){
        $request->validate([
          'thumbnail'   => 'image',
        ]);
        $photoPath = Storage::putFile('public', $request->file('thumbnail'));
        $post->thumbnail = $photoPath;
      }
      $post->title          = $request->input('title');
      $post->category_id    = $request->input('category');
      $post->text           = $request->input('text');
      $post->user_id        = $user->id;
      $post->status         = 0;

      $post->save();
      if($request->input('tags') != null ){
        $tags = str_replace('،',',',$request->input('tags'));
        $tags = explode(',',$tags);
        foreach ($tags as $key => $tag) {
          $selectedTag = Tag::firstOrCreate(
            ['name' => $tag],
            ['slug' => $tag]
          );
          $post->tags()->attach($selectedTag);
        }
      }
      return redirect()->route('postsList')->withErrors(new MessageBag(['messages' => 'مطلب در صف بررسی و انتشار قرار گرفت']));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('single',[
          'post'      => $post,
          'comments'  => $post->comments()->where('status',2)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

        return View('posts.edit',[
          'post' => $post,
          'tags' => implode(",",$post->tags()->get()->map(function ($tag) {
            return $tag->name;
          })->unique()->toArray()),
          'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // return $request->all();
        $user = $request->user();
        $request->validate([
          'title'       => 'required|string',
          'category'    => 'required|integer',
          'tags'        => 'string',
          'text'        => 'required|string',
        ]);
        if($request->hasFile('thumbnail')){
          $request->validate([
            'thumbnail'   => 'image',
          ]);
          $photoPath = Storage::putFile('public', $request->file('thumbnail'));
          $post->thumbnail = $photoPath;
        }
        $post->title          = $request->input('title');
        $post->category_id    = $request->input('category');
        $post->text           = $request->input('text');
        $post->user_id        = $user->id;
        $post->status         = 0;
        $post->save();
        if($request->input('tags') != null ){
          $tags = str_replace('،',',',$request->input('tags'));
          $tags = explode(',',$tags);
          foreach ($tags as $key => $tag) {
            $selectedTag = Tag::firstOrCreate(
              ['name' => $tag],
              ['slug' => $tag]
            );
            $post->tags()->attach($selectedTag);
          }
        }
        return redirect()->route('postsList')->withErrors(new MessageBag(['messages' => 'مطلب با موفقیت ویرایش شد']));

    }
    /**
     * Submit the Post to the blog.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request, Post $post)
    {
        // return $request->all();
        $user = $request->user();
        $post->status = 1;
        $post->save();
        return redirect()->route('postsList')->withErrors(new MessageBag(['messages' => 'مطلب با موفقیت منتشر شد']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->tag()->detach();
        $post->delete();
        return redirect()->route('postsList')->withErrors(new MessageBag(['messages' => 'مطلب با موفقیت حذف شد']));

    }
    /**
     * Show posts by tag.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPostByTag($slug)
    {
        return view('home',[
          'posts' => Tag::where('slug',$slug)->first()->posts()->where('status',1)->paginate(15)
        ]);
    }
    /**
     * Show posts by Category.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPostByCategory($slug)
    {
        return view('home',[
          'posts' => Category::where('slug',$slug)->first()->post()->where('status',1)->paginate(15)
        ]);
    }
}
