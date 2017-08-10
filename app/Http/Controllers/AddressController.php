<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Address\StoreAddress;
use App\Http\Transformers\AddressTransformer;

class AddressController extends Controller
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
    public function index(Request $request, AddressTransformer $transformer)
    {
        $addresses = $request->user()->addresses()->paginate(50);

        return Response::paginator($addresses, $transformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddress $request)
    {
        $request->user()->addresses()->create(
            $request->all()
        );

        return Response::created('Address successfully created.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Address $address)
    {
        $this->authorize('delete', $address);

        $address->delete();

        return Response::message('Address successfully deleted.');
    }
}
