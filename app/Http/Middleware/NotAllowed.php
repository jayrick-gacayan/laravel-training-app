<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotAllowed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $model): Response
    {
        $modelName = $request->route()->parameterNames[0];
        
        $tempModel = app($model)->find($request->route()->parameters[$modelName]);
        
        // $token_header_json = base64_decode($request->bearerToken());
        
        // dd($request->user());
        if($request->user()->id !== $tempModel->user_id){
            return Response(['message' => 'Unauthorized'],401);
        }

        return $next($request);
    }
}
