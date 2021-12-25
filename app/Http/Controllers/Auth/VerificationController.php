<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class VerificationController extends Controller
{
    public function verify($user_id, Request $request)
    {

        if (!$request->hasValidSignature()) {
            return response()->json(["message" => "Invalid/Expired url provided"], 401);
        }
        $user = User::findOrFail($user_id);
        if ($user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return Response::json(["message" => "Already verified"]);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return Response::json(["message" => "Success"], 201);
        }

    }

    public function resend(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if ($user) {
            if ($user->hasVerifiedEmail()) {
                return response()->json(["message" => "Email already verified."], 400);
            } else {
                $user->sendEmailVerificationNotification();
                return response()->json(["message" => "Email verification link sent on your email"],200);
            }
        } else {
            return response()->json(["message" => "User with current email not found"], 422);
        }
    }

    public function phoneVerification(Request $request){
        $userCode = DB::table('sms_verification_code')->where('user_id',$request->id)->first()->code;
        if ( Hash::check($request->code, $userCode)){
            User::find($request->id)->update(['phone_verified_at' => Carbon::now()]);
            return Response::json(['status' => 'success', 'message' => 'User verified']);
        } else {
            return Response::json(['status' => 'failed', 'message' => 'Fail code from SMS']);
        }
    }






}
