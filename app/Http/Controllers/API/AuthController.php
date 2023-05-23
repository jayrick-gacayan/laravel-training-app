<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Auth;

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
            if(!Auth::attempt($request->all())){
                return Response(['error' => 'Email and password did not match.'], 401);
            }
            else{
                $user = Auth::user();
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|max:8'
        ]);

        if(!$validator->fails()){
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            if($user){
                event(new Registered($user));
                $user->sendEmailVerificationNotification();
                return Response(['user' => $user, 'message' => 'Send email verification.'], 200);
            }

            return Response(['error' => 'Something went wrong.']);
        }

        return Response($validator->errors(), 400);
    }

    /**
     * method for user authentication logout
     * 
     * @return Illuminate/Http/Response
     */
    public function userLogout(): Response{
        if(Auth::guard('api')->check())
        {   
            $accessToken = Auth::guard('api')->user()->token();

            $accessToken->revoke();
            return Response(["message" => 'Successfully logout.'], 200);
        }
        
        return Response(["message" => 'Unauthorized.'], 400);
    }
}
