<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Throwable;
use Exception;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // $this->reportable(function (Throwable $e) {
        //     //
        // });

        $this->renderable(function(Exception $e, Request $request){
            if($request->is('api/*')){
                if($e instanceof NotFoundHttpException){
                    return Response([
                        'message' => ucfirst($request->route()->parameterNames[0]).' not found.'],
                        404);
                }
            }
        });
    }
}
