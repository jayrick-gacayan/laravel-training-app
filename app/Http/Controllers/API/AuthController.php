<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

use App\Mail\EmailVerifyOTP;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Otp;

use Mail;

class AuthController extends Controller
{
    /**
     * method for user authentication login
     * 
     * @return Illuminate\Http\Response
     */
    public function userLogin(Request $request): Response{
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);
        
        if(!$validator->fails()){
            $user = User::where('email', $request->input('email'));

            if(!$user->exists()){
                return Response(['message' => 'User not found.'], 404);
            }

            if(!Auth::attempt($request->all())){
                return Response(['message' => 'Email and password did not match.'], 401);
            }
            else{
                $user = Auth::user();

                if(!$user->hasVerifiedEmail()){
                    return Response([
                            'message' => 'Email is not yet verified. Please check your email address to verify.'
                        ], 400);
                }

                $token = $user->createToken('training')->accessToken;
                
                return Response([
                        'user' => $user,
                        'message'=> 'Successfully login.', 
                        'access_token' => $token], 
                    200);    
            }
        }
        
        return Response($validator->errors(), 400);
    }

    /**
     * method for user authentication registration
     * 
     * @return Illuminate\Http\Response
     */
    public function userRegister(Request $request){
        $validatedData =  Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|max:8'
        ]);

        if(!$validatedData->fails()){
            
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            if($user !== null){
                $user->update(['email_verified_at' => null]);
               
                $otp = Otp::create([
                    'code' => rand(100000, 999999),
                    'user_id' => $user->id,
                    'expired_at' => now()->addMinutes(15)
                ]);

                event(new Registered($user));
                
                $hash = sha1($user->getEmailForVerification());

                try{
                    Mail::to($user->email)->send(new EmailVerifyOTP($otp->code, $user->name, $user->email));
                    return Response([
                            'user' => $user, 
                            'message' => 'Successfully send OTP for email verification.', 
                            'hash' => $hash ], 
                        200);
                }catch(Exception $e){
                    return Response(['message' => 'Something went wrong. Please try again.'], 300);
                }
            }

            return Response(['error' => 'Something went wrong.']);
        }

        return Response($validatedData->errors(), 400);
    }

    /**
     * method for user authentication logout
     * 
     * @return Illuminate/Http/Response
     */
    public function userLogout(): Response{
        if(Auth::guard('api')->check())
        {   
            $user = Auth::guard('api')->user();
            
            $user->token()->revoke()->logout();

            return Response(["message" => 'Successfully logout.'], 200);
        }
        
        return Response(["message" => 'Unauthorized.'], 400);
    }

    public function forgotPassword(Request $request){
        
    }
}
