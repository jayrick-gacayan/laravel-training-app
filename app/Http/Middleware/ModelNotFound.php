<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModelNotFound
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$args)
    {  
        $modelName = $args[1];
        $model = app($args[0])->find($request->route($modelName));
        
        if(is_null($model)){
            return Response(['message' => ucfirst($modelName).' not found.'],404);
        }

        return $next($request);
    }
}
