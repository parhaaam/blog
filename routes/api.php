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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=> ['auth'],'prefix' => 'admin'],function () {
  Route::get('/categories','CategoryController@index')->name('catList')->middleware('can:viewAny,App\Category');
  Route::get('/category','CategoryController@create')->name('createCat')->middleware('can:create,App\Category');
  Route::post('/category','CategoryController@store')->name('storeCat')->middleware('can:create,App\Category');
  Route::get('/category/{category}','CategoryController@edit')->name('editCat')->middleware('can:update,category');
  Route::put('/category/{category}','CategoryController@update')->name('updateCat')->middleware('can:update,category');
  Route::delete('/category/{category}','CategoryController@destroy')->name('deleteCat')->middleware('can:delete,category');
});

Route::get('password-grant-auth', function (Request $request) {


    $http = new GuzzleHttp\Client;
    // Make call to "Tweeter," our Passport-powered OAuth server
    $response = $http->post('http://127.0.0.1:8002/oauth/token', [
        'form_params' => [
            'grant_type'    => 'password',
            'client_id'     => 6,
            'client_secret' => 'zvanzs1qCPjXTYnZvIS8e6LGUsWsOQh5CDVtf7gw',
            'username'      => $request->input('username'),
            'password'      => $request->input('password'),
            'scope'         => '',
            ],
          ]);

    return $thisUsersTokens = json_decode((string) $response->getBody(), true);
    // Do stuff with the tokens
});
