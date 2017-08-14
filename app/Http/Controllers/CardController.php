<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Stripe\Customer;
use Illuminate\Http\Request;
use Stripe\Error\Base as StripeException;
use Illuminate\Support\Facades\Response;

class CardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return  @void
     */
    public function __construct()
    {
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string|max:255'
        ]);

        $user = $request->user();
        $token = $request->token;

        try {
            if ($user->hasStripeId()) {
                $user->updateCustomerWithCard($token);
            } else {
                $user->createCustomerWithCard($token);
            }
        } catch(StripeException $e) {
            return Response::message($e->getMessage(), 400);
        }

        return Response::message('Card successfully added', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }
}
