<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return Response([
            'users' => $users
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return Response(['user' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
