<?php

namespace App\Http\Controllers\API\Master\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Model\Master\Business;
use App\Model\Master\EmailToken;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Response;
use App\User;
use Hyn\Tenancy\Models\Website;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group  Email Verification
 *
 * APIs for Email Verification
 */
class EmailVerificationController extends Controller
{

    /**
     * Send confirmation email to the user email  or update email and then send verification email
     * @bodyParam  email string The email that user wants to update. 
     * @response{
     *           "success": "A verification link has been sent to your email"
     *  }
     * 
     * @response  422 {
     *"message": "You are verified before",
     *"errors": {
     *    "mail": [
     *                  "Your email has been verified before"
     *              ]
     *          }
     *       }
     *
     * @param \Illuminate\Http\Request $request
     */
    public function SendEmail(AuthRequest $request)
    {
        if (request()->has('email')) {
            $user = request()->user();
            $user->email = $request->input('email');
            $user->email_verified_at = null;
            $user->saveOrFail();

            $businesses = $user->businesses;
            foreach ($businesses as $key => $business) {
                $website_id = Business::findOrFail($business->id)->website_id;
                $website = Website::find($website_id);
                DB::table($website->uuid.'.users')->where('mobile', $user->mobile)->update([
                    'email' => $request->input('email'),
                    'email_verified_at'  => null,
                ]);
            }
        }

        if ($request->user()->hasVerifiedEmail()) {
            return response([
                'message' => 'You are verified before',
                'errors'  => [
                    'mail' => __('validation.custom.mail.verified_before')
                ]
            ], 422);
        }

        $request->user()->sendEmailVerificationNotification();

        return response([
            'success' => __('validation.custom.mail.sent')
        ], 200);
    }
    /**
     * Verify user email
     * @bodyParam  code required The hash of the user email.
     * @response{
     *           "success": "Your email has been activated successfully",
     * "user": {
     *   "id": 9,
     *   "name": "معین",
     *   "mobile": "09132966711",
     *   "email": "mehrparvar.moein@gmail.com",
     *   "email_verified_at": "2020-08-31T10:54:30.000000Z"
     *   }
     *  }
     * 
     * @response  422 {
     *"message": "Invalid input",
     *"errors": {
     *    "mail": [
     *                  "Invalid Activation Link",
     *                  "Your email has been verified before"
     *              ]
     *          }
     *       }
     *
     * @param \Illuminate\Http\Request $request
     */
    public function verifyCode(AuthRequest $request)
    {
        $user = $request->user();
        $emailToken = EmailToken::where('user_id',$user->id)->first();
        if ( empty($emailToken)) {
            return response([
                'message' => 'No Token',
                'errors'  => [
                    'mail' => __('validation.custom.mail.no_token')
                ]
            ], 422);
        }
        if ($emailToken->token != $request->input('code')) {
            return response([
                'message' => 'Invalid input',
                'errors'  => [
                    'mail' => __('validation.custom.mail.code')
                ]
            ], 422);
        }


        if ($user->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        $businesses = $user->businesses;
        foreach ($businesses as $key => $business) {
            $website_id = Business::findOrFail($business->id)->website_id;
            $website = Website::find($website_id);
            DB::table($website->uuid.'.users')->where('mobile', $user->mobile)->update([
                'email_verified_at'  => now(),
            ]);
        }
        
        return response([
            'success' => __('validation.custom.mail.success'),
            'user'    => $user,
        ], 200);
    }
}
