<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Stripe\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Stripe\Error\Base as StripeException;
use App\Http\Transformers\CardTransformer;

class CardController extends Controller
{
    protected $transformer;

    /**
     * Create a new controller instance.
     *
     * @return  @void
     */
    public function __construct(CardTransformer $transformer)
    {
        $this->transformer = $transformer;

        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cards = $request->user()->cards()->with('address')->get();

        return Response::collection($cards, $this->transformer);
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

        $card = $user->cards()->with('address')->latest()->first();

        return Response::createdWithItem('Card successfully added.', $card, $this->transformer);
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
