<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=> ['auth']],function () {
  Route::get('/posts','PostController@index')->name('postsList');
  Route::get('/post','PostController@create')->name('createPost');
  Route::get('/post/{post?}','PostController@edit')->name('editPost');

  Route::get('/categories','CategoryController@index')->name('catList');
  Route::get('/category','CategoryController@create')->name('createCat');
  Route::get('/category/{category?}','CategoryController@edit')->name('editCat');

  Route::get('/tags','TagController@index')->name('tagList');
  Route::get('/tag','TagController@create')->name('createTag');
  Route::get('/tag/{tag?}','TagController@edit')->name('editTag');

  Route::get('/users','UserController@index')->name('usersList');
  Route::get('/user','UserController@create')->name('createUser');
  Route::get('/user/{user?}','UserController@edit')->name('editUser');

});
