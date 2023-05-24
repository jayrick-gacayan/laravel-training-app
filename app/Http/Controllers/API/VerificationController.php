<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Events\Verified;
// use Illuminate\Foundation\Auth\EmailVerificationRequest as EmailRequest;
use App\Models\User;
use Auth;

class VerificationController extends Controller
{
    /**
     * 
     * 
     * @return Illuminate\Http\Response
     */
    public function verify($user_id, $hash, Request $request){

        
        if (!$request->hasValidSignature()) {
            return response()->json(['msg' => 'Invalid/Expired url provided.'], 401);
        }

        $user = User::findOrFail($user_id);

        // dd($user);
        abort_if(!$user, 404); // user not found;
        // abort_if(!hash_equals(sha1($user->getEmailForVerification()), $hash),403);


        if(!$user->hasVerifiedEmail()){
            $user->update(['is_email_verified' => true]);
            $user->markEmailAsVerified();
            event(new Verified($user));
            return Response(['message' => 'Email is successfully verified.'], 200);
        }

        return Response(['message' => 'Email is already verified'], 300);
    }

    /**
     * 
     * 
     * @return Illuminate\Http\Response
     */
    public function resend(Request $request){
        if($request->user()->hasVerifiedEmail() !== null){
            return Response(['message'=> 'Email is already verified.'], 300);
        }

        auth()->user()->sendEmailVerificationNotification();
        return Response(['message'=> 'Email verification link is sent on your email id.'], 200);
    }

    public function viewVerifyEmail(){
        return view('auth.verify-email');
    }
}
