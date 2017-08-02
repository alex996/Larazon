<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Transformers\CartTransformer;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CartController extends Controller
{
    /**
     * Transformer.
     * 
     * @var CategoryTransformer
     */
    protected $transformer;
    
    /**
     * Create a new controller instance.
     * 
     * @param CategoryTransformer $transformer
     */
    public function __construct(CartTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasCookie('uuid')) {
            throw new BadRequestHttpException;
        }

        $cart = Cart::create([]);

        return Response::item($cart, $this->transformer)
            ->withCookie('uuid', $cart->uuid, 60*24*7);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
