<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group  Register
 *
 * APIs for Auth management
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    

    public function register(Request $request)
    {
     
        $request->validate([
            'email' =>  'unique:users,email'
        ]);
        $user = User::create([
            'name'          => $request->input('name'),
            'email'         => $request->input('email'     ),
            'password'      => Hash::make($request->input('password'  )),
        ]);
        
        $access_token = $user->createToken('Master')->accessToken;
        return response()->json([
            'success'   => "ثبت نام با موفقیت همراه بود",
            'token'     => $access_token,
        ], 200);
    }


   
}
