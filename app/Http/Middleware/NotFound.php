<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotFound
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $model)
    {  
        dd($request->route('user'));
        // $modelName = $request->route()->parameterNames[0];
        
        // $tempModel = app($model)->find($request->route()->parameters[$modelName]);

        // $asRoute = $request->route()->action["as"];
        
        // if(is_null($tempModel)){
        //     return Response(['message' => ucfirst(substr($asRoute,0, strlen($asRoute) - 2)).' not found.'], 404);
        // }

        // return $next($request);
    }
}
