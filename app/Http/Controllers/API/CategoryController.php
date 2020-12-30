<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::orderBy('created_at','DESC')->paginate(15);
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
          'slug' => 'required|string|unique:categories'
        ]);
        $cat = Category::create($request->all());
        return response(['messages' => 'دسته‌بندی با موفقیت ثبت شد']);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
      $request->validate([
        'name' => ['required','string'],
        'slug' => ['required','unique:categories,slug,'.$category->id,'string']
      ]);
      $category->name = $request->input('name');
      $category->slug = $request->input('slug');
      $category->save();
      return response(['messages' => 'دسته‌بندی با موفقیت ویرایش شد']);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response(['messages' => 'دسته‌بندی با موفقیت حذف شد']);

    }
}
