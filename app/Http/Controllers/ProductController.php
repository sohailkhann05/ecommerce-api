<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCollection::collection(Product::paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'stock' => $request->stock,
            'price' => $request->price,
            'discount' => $request->discount,
        ]);

        // $product = new Product;

        // $product->name = $request->name;
        // $product->description = $request->description;
        // $product->stock = $request->stock;
        // $product->price = $request->price;
        // $product->discount = $request->discount;

        // $product->save();

        // $product = DB::table('products')->insert([
        //     'name' => $request->name,
        //     'description' => $request->description,
        //     'stock' => $request->stock,
        //     'price' => $request->price,
        //     'discount' => $request->discount,
        // ]);

        return response([
            'data' => new ProductResource($product)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if (Auth::id() == $product->user_id) {
            $product->update($request->all());

            return response([
                'data' => new ProductResource($product)
            ], Response::HTTP_CREATED);
        } else {
            return response()->json([
                'errors' => 'Product not belongs to this User.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (Auth::id() == $product->user_id) {
            $product->delete();
            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            return response()->json([
                'errors' => 'Product not belongs to this User.'
            ]);
        }
    }
}
