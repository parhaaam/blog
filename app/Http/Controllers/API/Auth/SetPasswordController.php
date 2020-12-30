<?php

namespace App\Http\Controllers\API\Master\Auth;

use App\Exceptions\NotSave;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Model\Master\Business;
use App\User;
use Illuminate\Http\Request;
use App\SMSToken;
use Exception;
use Hyn\Tenancy\Models\Website;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * @group  Forget Password
 *
 * 
 * APIs for Forget Password 
 */
class SetPasswordController extends Controller
{


/**
     * Send confirmation sms to the user mobile  
     * @bodyParam  mobile string required The Mobile number of user,'max:11'. Example: 09139999999
     * @response{
     *           "success": "The confirmation code has been sent to your Phone Number",
     *           "expire": "2"
     *  }
     * 
     * @response  422 {
     *"message": "The given data was invalid.",
     *"errors": {
     *    "mobile": [
     *          "The mobile may not be greater than 11 characters.",
     *          "The mobile format is invalid.",
     *          "There is not any user with this phone number"
     *    ]
     *}
     *       }
     * @response  404 {
     *"message": "The given data was invalid.",
     *"errors": {
     *    "mobile": [
     *          "The mobile may not be greater than 11 characters."
     *              ]
     *          }
     *}
     *
     * @param \Illuminate\Http\Request $request
     */
    public static function SendSMS(AuthRequest $request){
        
        $user = User::where('mobile',$request->input('mobile'))->firstOrFail();

        // send verify sms and insert sms token to database
        $send_sms = SMSToken::SendVerifySms($request);

        return response()->json([
            'success' => __('user.forget.sms_success'),
            'expire'  => $send_sms['expire'],
        ], 200);
        
    }

    /**
     * Verify Confirmation Code
     * @bodyParam  mobile string required The Mobile number of user,'max:11'. Example: 09139999999
     * @response{
     *           "success": "Your Phone Number has been confirmed",
     *           "secret": "token"
     *  }
     * 
     * @response  422 {
     *"message": "The given data was invalid.",
     *"errors": {
     *    "token": [
     *        "The Token has been expired",
     *        "Wrong token",
     *        "The token field is required.",
     *        "The token must be 6 digits."
     *    ],
     *    "mobile": [
     *          "The mobile may not be greater than 11 characters.",
     *          "The mobile format is invalid.",
     *          "There is not any user with this phone number"
     *    ]
     *}
     *       }
     * @param \Illuminate\Http\Request $request
     */
    public function verifyCode(AuthRequest $request)
    {
        $user = User::where('mobile', $request->input('mobile'))->firstOrFail();

        switch (SMSToken::Verify($request)) {
            case SMSToken::SMSTOKEN_SUCCESS:

                $user->status = User::USER_CHANGE_PASSWORD_STATE;
                try {
                    $user->save();
                } catch (Exception $exception) {
                    Log::error('set password save');
                    throw new NotSave($exception);
                }                
                // $success =  $user->createToken('Master')->accessToken;
                // Cache::put('passport_'. $user->mobile, encrypt($user->mobile) , now()->addSeconds(5));
                // $request->merge(['password' => Hash::make('pass' . $user->mobile . $user->id)]);
                // $success['token'] = User::generateToken (
                //     $request,
                //     'password',
                //     'system'
                // );
                $secret = encrypt($user->mobile);
                return response()->json([
                    'success'   =>  __('user.forget.verify_success'),
                    'secret'     => $secret,
                    ], 200);
            case SMSToken::SMSTOKEN_EXPIRE:
                return response([
                    'message' => 'The given data was invalid.',
                    'errors'  => [
                        'token' => __('validation.custom.token.expired')
                    ]
                ], 422);

            case SMSToken::SMSTOKEN_WRONG:
                // Token is wrong
                return response([
                    'message' => 'The given data was invalid.',
                    'errors'  => [
                        'token' => __('validation.custom.token.wrong')
                    ]
                ], 422);
        }
    }
    /**
     * Reset user password
     * @bodyParam  mobile string required The Mobile number of user, max:11. Example: 09139999999
     * @bodyParam  password string required The password of user, min:8. Example: 12345678
     * @bodyParam  password_confirmation string required The password of user. Example: M12345678
     * @bodyParam  secret string required The token for reset password.
     * @response{
     *      "success": "Your password successfully has been changed"
     *  }
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     * @response  422 {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *      "user" : [
     *              "Your Phone Number has not been confirmed for password reset"
     *       ],
     *      "mobile": [
     *          "The selected mobile is invalid.",
     *          "The mobile may not be greater than 11 characters.",
     *          "The mobile format is invalid."
     *      ],
     *      "password": [
     *          "The password confirmation does not match.",
     *          "The password must be at least 8 characters.",
     *          "Password is required"
     *      ],
     *      "secret": [
     *          "The secret field is required."
     *      ]
     *    }
     * }
     */
    public function ChangePassword(AuthRequest $request)
    {
        
        //update User password
        $user = User::where('mobile', decrypt($request->secret))->firstOrFail();
        
        if($user->status == User::USER_CHANGE_PASSWORD_STATE){
            $user->password = $request->input('password');
                $user->status = User::USER_ACTIVE;
                $user->save();

                $businesses = $user->businesses;
                foreach ($businesses as $key => $business) {
                    $website_id = Business::findOrFail($business->id)->website_id;
                    $website = Website::find($website_id);
                    DB::table($website->uuid.'.users')->where('mobile', $user->mobile)->update([
                        'password' => Hash::make($request->input('password')),
                    ]);
                }
        }else{
            return response([
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'user' => __('user.forget.user_phone_not_confirmed')
                ]
            ], 422);
        }
        
        return response()->json([
                                'success' => __('user.forget.password_rest_success')
                            ], 200);
    }

}