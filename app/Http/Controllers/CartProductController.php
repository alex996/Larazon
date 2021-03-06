<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Response;
use App\Http\Transformers\ProductTransformer;
use App\Http\Requests\CartProduct\{DestroyCartProduct, StoreCartProduct, UpdateCartProduct};

class CartProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductTransformer $transformer, Cart $cart)
    {
        return Response::collection($cart->products, $transformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCartProduct $request, Cart $cart)
    {
        $productId = Product::whereSlug($request->slug)->value('id');

        $cart->products()->attach(
            $productId, ['quantity' => $request->quantity]
        );

        return Response::created('Product successfully added to the cart.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartProduct $request, Cart $cart, Product $product)
    {
        $cart->products()->updateExistingPivot($product->id, [
            'quantity' => $request->quantity
        ]);

        return Response::message('Product quantity successfully updated in the cart.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyCartProduct $request, Cart $cart, Product $product)
    {
        $cart->products()->detach($product->id);

        return Response::message('Product successfully removed from the cart.');
    }
}
