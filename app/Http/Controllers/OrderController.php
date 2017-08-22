<?php

namespace App\Http\Controllers;

use Exception;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Orders\StoreOrder;
use App\Http\Transformers\OrderTransformer;

class OrderController extends Controller
{
    protected $transfomer;

    /**
     * Create a new controller instance.
     *
     * @return  @void
     */
    public function __construct(OrderTransformer $transfomer)
    {
        $this->transfomer = $transfomer;

        $this->middleware('jwt.auth');
    }

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
    public function store(StoreOrder $request)
    {
        // check that user has any *active* carts (Policy?)

        $user = $request->user();


        // check that all products in stock

        //$cart = Cart::with('products')->whereUid($request->uid)->first();

        try {
            //$user->placeOrder($car)
            //$user->charge($cart->subtotal());
        } catch(Exception $e) {
            return Response::message($e->getMessage(), 400);
        }
        
        return Response::createdWithItem('Order successfully placed.', $order, $transfomer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
