<?php

namespace App\Http\Controllers\API;

use App\Post;
use App\Category;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->role > 1){
          $posts = Post::orderBy('created_at','DESC')->paginate(15);
        }else {
          $posts = Post::where('user_id',$request->user()->id)->orderBy('created_at','DESC')->paginate(15);
        }

        return $posts;
        
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

          $isAttached = DB::table('post_tag')->where('post_id', '=', $post->id)->where('tag_id', '=', $selectedTag->id)->count();
          if($isAttached > 0){
            continue;
          }
          $post->tags()->attach($selectedTag);
        }
      }
      return response(['messages' => 'مطلب در صف بررسی و انتشار قرار گرفت']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->comments = $post->comments()->where('status',2)->get();
        return $post;
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
            $isAttached = DB::table('post_tag')->where('post_id', '=', $post->id)->where('tag_id', '=', $selectedTag->id)->count();
            if($isAttached > 0){
              continue;
            }
            $post->tags()->attach($selectedTag);
          }
        }
        return response(['messages' => 'مطلب با موفقیت ویرایش شد']);

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
        return response(['messages' => 'مطلب با موفقیت منتشر شد']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->tags()->detach();
        $post->comments()->get()->map(function ($comment) {
          $comment->delete();
        });
        $post->delete();
        return response(['messages' => 'مطلب با موفقیت حذف شد']);

    }
    /**
     * Show posts by tag.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPostByTag($slug)
    {
        return Tag::where('slug',$slug)->first()->posts()->where('status',1)->paginate(15);
       
    }
    /**
     * Show posts by Category.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPostByCategory($slug)
    {
        return Category::where('slug',$slug)->first()->post()->where('status',1)->paginate(15);
        
    }
}
