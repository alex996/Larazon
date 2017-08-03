<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $item = new CartItem;
        $item->product_id = $request->product_id;
        $item->quantity = $request->quantity;
        $cart->addItem($item);

        return Response::json([], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartItem $cartItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem $cartItem)
    {
        //
    }
}
