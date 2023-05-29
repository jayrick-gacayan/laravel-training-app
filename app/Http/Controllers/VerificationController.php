<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
// use Illuminate\Foundation\Auth\EmailVerificationRequest as EmailRequest;
use App\Models\User;

class VerificationController extends Controller
{
    /**
     * 
     * 
     * @return Illuminate\Http\Response
     */
    public function verify($user_id, Request $request){
        $user = User::find($user_id);

        if(is_null($user)){
            return Response(['message' => 'User not found'],404);
        }
        
        if($user->hasVerifiedEmail()){
            return Response(['message' => 'Email has been already verified.'], 300);
        }

        $otp = $user->otp()->first();
        
        // if($otp->expired_at->gt(now())){
        //     return Response(['message' => 'OTP code is expired.'],200);
        // }

        if($otp->code !== $request->input('code')){
            return Response([ 'message' => 'OTP did not match.'],401);
        }

        if(!$user->hasVerifiedEmail()){
            $user->update(['is_email_verified' => true]);
            $user->markEmailAsVerified();
            event(new Verified($user));
            return Response(['message' => 'Email is successfully verified.'], 200);
        }

        return Response(['message' => 'Something went wrong.'], 500);
    }

    /**
     * 
     * 
     * @return Illuminate\Http\Response
     */
    public function resend(Request $request){
        
        dd($request->user()->hasVerifiedEmail());
        // if($request->user()->hasVerifiedEmail()){
        //     return Response(['message'=> 'Email is already verified.'], 300);
        // }

        // auth()->user()->sendEmailVerificationNotification();
        // return Response(['message'=> 'Email verification link is sent on your email id.'], 200);
    }

    public function viewVerifyEmail(){
        return view('auth.verify-email');
    }
}
