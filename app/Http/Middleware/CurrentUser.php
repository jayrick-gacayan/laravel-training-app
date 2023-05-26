<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrentUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $modelName = $args[1];
        $model = app($args[0])->find($request->route($modelName));
        
        if($request->user()->id !== $model->user_id){
            return Response(['message' => 'Unauthorized'],401);
        }

        return $next($request);
        // dd($request->bearerToken());
        // dd($request->bearerToken());
        // return $next($request);
    }
}
