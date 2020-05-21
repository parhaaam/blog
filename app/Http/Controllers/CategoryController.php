<?php

namespace App\Http\Controllers;

use App\Category;
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
        return View('category.index',[
          'cats' => Category::paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return View('category.create');
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
        return redirect()->route('catList')->withErrors(new MessageBag( ['messages' => 'دسته‌بندی با موفقیت ثبت شد']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
      return View('category.edit',[
        'cat' => $category
      ]);

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
      return redirect()->route('catList')->withErrors(new MessageBag( ['messages' => 'دسته‌بندی با موفقیت ویرایش شد']));


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
        return redirect()->route('catList')->withErrors(new MessageBag( ['messages' => 'دسته‌بندی با موفقیت حذف شد']));

    }
}
