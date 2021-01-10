<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group([],function () {

  //Login Routes
  Route::post('/login',    'API\Auth\LoginController@login')->name('loginWithPassword');
  Route::post('/register', 'API\Auth\RegisterController@register')->name('sendVerifyCodeRegister');


  Route::get('/', 'API\HomeController@index')->name('home');
  Route::get('post/{post}', 'API\PostController@show')->name('single');
  Route::get('tag/{slug}', 'API\PostController@getPostByTag')->name('tagPosts');
  Route::get('category/{slug}', 'API\PostController@getPostByCategory')->name('postByCat');
  Route::post('/comment/{post}','API\CommentController@store')->name('storeComment');
  Route::post('/like/{post}','API\LikesController@store')->name('storeLike');



});
Route::group(['middleware'=> ['auth:api'],'prefix' => 'admin' , 'namespace' => 'API' ],function () {
  Route::get('/posts','PostController@index')->name('postsList')->middleware('can:viewAny,App\Post');
  Route::get('/post','PostController@create')->name('createPost')->middleware('can:create,App\Post');
  Route::post('/post','PostController@store')->name('storePost')->middleware('can:create,App\Post');
  Route::get('/posts/{post}','PostController@edit')->name('editPost')->middleware('can:update,post');
  Route::put('/posts/{post}','PostController@update')->name('updatePost')->middleware('can:update,post');
  Route::put('/posts/submit/{post}','PostController@submit')->name('submitPost')->middleware('can:submit,post');
  Route::delete('/post/{post}','PostController@destroy')->name('deletePost')->middleware('can:delete,post');

  Route::get('/comments','CommentController@index')->name('commentsList')->middleware('can:viewAny,App\Comment');
  Route::put('/comment/{comment}','CommentController@submit')->name('submitComment')->middleware('can:update,comment');
  Route::put('/comment/spam/{comment}','CommentController@spam')->name('spamComment')->middleware('can:spam,comment');
  Route::delete('/comment/{comment}','CommentController@destroy')->name('deleteComment')->middleware('can:delete,comment');




  Route::get('/categories','CategoryController@index')->name('catList')->middleware('can:viewAny,App\Category');
  Route::get('/category','CategoryController@create')->name('createCat')->middleware('can:create,App\Category');
  Route::post('/category','CategoryController@store')->name('storeCat')->middleware('can:create,App\Category');
  Route::get('/category/{category}','CategoryController@edit')->name('editCat')->middleware('can:update,category');
  Route::put('/category/{category}','CategoryController@update')->name('updateCat')->middleware('can:update,category');
  Route::delete('/category/{category}','CategoryController@destroy')->name('deleteCat')->middleware('can:delete,category');


  Route::get('/tags','TagController@index')->name('tagList')->middleware('can:viewAny,App\Tag');
  Route::get('/tag','TagController@create')->name('createTag')->middleware('can:create,App\Tag');
  Route::post('/tag','TagController@store')->name('storeTag')->middleware('can:create,App\Tag');
  Route::get('/tags/{tag}','TagController@edit')->name('editTag')->middleware('can:update,tag');
  Route::put('/tags/{tag}','TagController@update')->name('updateTag')->middleware('can:update,tag');
  Route::delete('/tags/{tag}','TagController@destroy')->name('deleteTag')->middleware('can:delete,tag');


  Route::get('/users','UserController@index')->name('usersList')->middleware('can:viewAny,App\User');
  Route::get('/user','UserController@create')->name('createUser')->middleware('can:create,App\User');
  Route::post('/user','UserController@store')->name('storeUser')->middleware('can:create,App\User');
  Route::get('/user/{user}','UserController@edit')->name('editUser')->middleware('can:update,user');
  Route::put('/user/{user}','UserController@update')->name('updateUser')->middleware('can:update,user');
  Route::delete('/user/{user}','UserController@destroy')->name('deleteUser')->middleware('can:delete,user');


});