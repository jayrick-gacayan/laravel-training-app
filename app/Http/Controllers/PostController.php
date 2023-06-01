<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;

use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all();

        return Response(['posts' => $posts],200);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required|max:255'
        ]);
   
        if($validator->fails()){
            return Response($validator->errors(), 400); 
        }

        $post = auth()->user()->posts()->create([
            "title" => $request->input('title'),
            'description'=> $request->input('description')
        ]);

        return Response([
            'post' => $post, 
            'message'=> 'Post successfully created'],
        200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return Response(['post' => $post], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
