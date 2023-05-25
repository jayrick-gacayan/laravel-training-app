<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;

class ProductController extends Controller
{
    /**
    * Constructor.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     * 
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::all();

        return Response(['products' => $products],200);
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
            'name' => 'required|max:255',
            'detail' => 'required|max:255',
            'price' => 'required|decimal'
        ]);
   
        if($validator->fails()){
            return Response($validatedData->errors(), 400); 
        }
        
        $product = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price')
        ]);


        return Response([
                'product' => $product, 
                'message'=> 'Product successfully created'],
            200);
    }

    /**
     * Display the specified resource.
     * 
     * @return Illuminate\Http\Response
     */
    public function show(string $id)
    {
        //
        $product = Product::find($id);

        if(is_null($product)){
          return Response(['message' => 'Product not found'],404);
        }
        return Response(['product' => $product],200);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'detail' => 'required|max:255',
            'price' => 'required|decimal'
        ]);
   
        if($validator->fails()){
            return Response($validatedData->errors(), 400); 
        }

        $product->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price')
        ]);

        return Response(['product', $product],200);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @return Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $deleteProduct = $product->delete();

        return Response(['product' => $deleteProduct, 'message', 'Product deleted successfully'],200);
    }
}
