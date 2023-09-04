<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {

        //dd(Auth::user());
        if ($request->is('api/*')) {
            if (Auth::guard('api')->check()) {
                Response(['message' => 'Unauthorized'], 401);
            }
        }

        return $next($request);

        // $guards = empty($guards) ? [null] : $guards;

        // foreach ($guards as $guard) {

        //     if (Auth::guard($guard)->check()) {
        //         return $guard == 'api' ?
        //             Response(['message' => 'Unauthorized'], 401) :
        //             redirect(RouteServiceProvider::HOME);
        //     }
        // }


    }
}
