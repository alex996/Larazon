<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
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

        if ($user->hasStripeId()) {
            $user->updateCard($token);
        } else {
            $user->createAsStripeCustomer($token);
           /* $customer = \Stripe\Customer::create(
                [
                    'email' => $user->email,
                    'source' => $token
                ], config('services.stripe.secret')
            );

            $user->stripe_id = $customer->id;
            $card = $customer->sources->data[0];
            $user->card_brand = $card['brand'];
            $user->card_last_four = $card['last4'];
            $user->save();*/
            //$user->brand
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
