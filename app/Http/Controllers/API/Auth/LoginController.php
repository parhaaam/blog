<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * @group  Authentication
 *
 * APIs for Auth management
 */

class LoginController extends Controller
{


    public function login(Request $request)
    {
        $request->validate([
            'email'         => ['required', 'string', 'exists:users'],
            'password'      => ['required', 'string'],
        ]);


        //Authenticate user
        if ( Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            //Authentication passed...
            $user = Auth::user();

            $success['token'] =  $user->createToken('Master')->accessToken;
            return response()->json(['success' => $success], 200);
        }

        //Authentication failed...
        throw ValidationException::withMessages(
            [
                'password' => __('auth.failed')
            ]
        )->status(422);
    }

   
}
