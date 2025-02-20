<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function getProducts()
    {
        $products = Product::with('category')->get();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createProduct(Request $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'pricing' => $request->pricing,
            'description' => $request->description,
        ]);

        if(!$product){
            return response()->json(['message' => 'Error creating product'], 400);
        }

        return response()->json(['message' => 'Creating a new product', 'product' => $product], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getProduct( $productId)
    {
        $product = Product::with('category')->find($productId);

        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function updateProduct(Request $request, $productId)
    {
        $product = Product::find($productId);
        $product->update($request->all());
        return response()->json(['message' => 'Updating product with id: '. $productId, 'product' => $product]);
    }

    public function deleteProduct( $productId)
    {
        $product = Product::find($productId);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}