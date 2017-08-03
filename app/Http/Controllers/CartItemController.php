<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CartItemController extends Controller
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
     **
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cart $cart)
    {
        $this->validate($request, [
            'slug' => 'required|exists:products,slug',
            'quantity' => 'required|integer|min:1'
        ]);

        $item = new CartItem;
        $item->product_id = Product::whereSlug($request->slug)->value('id');
        $item->quantity = $request->quantity;
        $cart->addItem($item);

        return Response::json([], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartItem  $item
     * @return \Illuminate\Http\Response
     */
    public function show(CartItem $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartItem  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart, CartItem $item)
    {
        $this->validate($request, [
            'quantity' => 'required|integer|min:1|not_in:'.$item->quantity,
        ]);

        $item->quantity = $request->quantity;
        $item->save();

        return Response::json([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartItem  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem $item)
    {
        //
    }
}
