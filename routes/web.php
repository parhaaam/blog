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



Auth::routes();
Route::group([],function () {

  Route::get('/', 'HomeController@index')->name('home');
  Route::get('post/{post}', 'PostController@show')->name('single');
  Route::post('/comment/{post}','CommentController@store')->name('storeComment');
  Route::post('/like/{post}','LikesController@store')->name('storeLike');



});
Route::group(['middleware'=> ['auth']],function () {
  Route::get('/posts','PostController@index')->name('postsList');
  Route::get('/post','PostController@create')->name('createPost');
  Route::post('/post','PostController@store')->name('storePost');
  Route::get('/posts/{post}','PostController@edit')->name('editPost');
  Route::put('/posts/{post}','PostController@update')->name('updatePost');
  Route::put('/posts/submit/{post}','PostController@submit')->name('submitPost');
  Route::delete('/post/{post}','PostController@destroy')->name('deletePost');

  Route::get('/comments','CommentController@index')->name('commentsList');
  Route::get('/comment','CommentController@create')->name('createComment');
  Route::put('/comment/{comment}','CommentController@submit')->name('submitComment');
  Route::put('/comment/spam/{comment}','CommentController@spam')->name('spamComment');
  Route::delete('/comment/{comment}','CommentController@destroy')->name('deleteComment');




  Route::get('/categories','CategoryController@index')->name('catList');
  Route::get('/category','CategoryController@create')->name('createCat');
  Route::post('/category','CategoryController@store')->name('storeCat');
  Route::get('/category/{category}','CategoryController@edit')->name('editCat');
  Route::put('/category/{category}','CategoryController@update')->name('updateCat');
  Route::delete('/category/{category}','CategoryController@destroy')->name('deleteCat');


  Route::get('/tags','TagController@index')->name('tagList');
  Route::get('/tag','TagController@create')->name('createTag');
  Route::post('/tag','TagController@store')->name('storeTag');
  Route::get('/tag/{tag}','TagController@edit')->name('editTag');
  Route::put('/tag/{tag}','TagController@update')->name('updateTag');
  Route::delete('/tag/{tag}','TagController@destroy')->name('deleteTag');


  Route::get('/users','UserController@index')->name('usersList');
  Route::get('/user','UserController@create')->name('createUser');
  Route::post('/user','UserController@store')->name('storeUser');
  Route::get('/user/{user}','UserController@edit')->name('editUser');
  Route::put('/user/{user}','UserController@update')->name('updateUser');
  Route::delete('/user/{user}','UserController@destroy')->name('deleteUser');


});
