<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Events\Verified;
use App\Models\User;

class VerificationController extends Controller
{
    /**
     * 
     * 
     * @return Illuminate\Http\Response
     */
    public function verify($user_id, $hash, Request $request){
        // if (!$request->hasValidSignature()) {
        //     return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        // }

        $user = User::findOrFail($user_id);

        abort_if(!$user, 404); // user not found;
        abort_if(!hash_equals(sha1($user->getEmailForVerification())),403);


        if(!$user->hasVerifiedEmail()){
            $user->markEmailAsVerified();
            $user->update(['is_email_verified' => true]);
            event(new Verified($user));
        }

        return Response(['message' => 'Verified Successfully.']);
    }

    /**
     * 
     * 
     * @return Illuminate\Http\Response
     */
    public function resend(){
        if(auth()->user()->hasVerifiedEmail()){
            return Response(['message'=> 'Email is already verified.'], 300);
        }

        auth()->user()->sendEmailVerificationNotification();
        return Response(['message'=> 'Email verification link is sent on your email id.'], 200);
    }

    public function viewVerifyEmail(){
        return view('auth.verify-email');
    }
}
