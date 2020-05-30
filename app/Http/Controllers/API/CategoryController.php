<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;


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
          return response(['Message' => 'Category inserted successfully','data' => $cat],200);
      }

      /**
       * Display the specified resource.
       *
       * @param  \App\Category  $category
       * @return \Illuminate\Http\Response
       */
      public function show(Category $category)
      {
          return $category;
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
        return response(['Message' => 'Category updated successfully','data' => $category],200);


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
          return response(['Message' => 'Category deleted successfully'],200);

      }
}
