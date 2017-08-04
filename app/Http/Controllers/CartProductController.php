<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CartProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cart $cart)
    {
        // TODO check product not in cart
        // TODO move logic to add to Cart.php
        
        $data = $this->validate($request, [
            'slug' => 'required|exists:products,slug',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = Product::whereSlug($request->slug)->select('id')->value('id');
        $cart->products()->attach(
            $productId, array_only($data, 'quantity')
        );

        return Response::json([], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart, Product $product)
    {
        // TODO: check product belongs to cart
        // TODO: move logic to update to Cart.php
        // TODO: check that quantity is not in $cart->pivot->quantity
        
        $data = $this->validate($request, [
            'quantity' => 'required|integer|min:1|max:'.$product->quantity
        ]);

        $cart->products()->updateExistingPivot($product->id, $data);

        return Response::json([], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart, Product $product)
    {
        // TODO: check product belongs to cart
        
        $cart->products()->detach($product->id);

        return Response::json([], 204);
    }
}
