<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Exception;

class CustomException extends Exception
{
    //

    /**
     * 
     * 
     * @return Illuminate\Http\Response
     */
    public function render(Request $request): Response{
        return Response(['message' => 'not found'],400);
    }
}
