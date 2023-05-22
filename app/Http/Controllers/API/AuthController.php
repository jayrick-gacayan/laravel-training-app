<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
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
            'email' => 'required|max:255',
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
    public function userRegister(){
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|unique:users',
            'password' => 'required|max:8'
        ]);
    }

    /**
     * method for user authentication logout
     * 
     * @return Illuminate/Http/Response
     */
    public function userLogout(): Response{
        Auth::user()->token()->revoke();
        return Response(["message" => 'Successfully logout.'], 200);
    }
}
