<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Transformers\ProductTransformer;

class ProductController extends Controller
{
    protected $transformer;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request
     * @param  ProductTransformer $transformer
     */
    public function __construct(ProductTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::paginate(50);

        return Response::paginator($products, $this->transformer);
    }

    /**
     * Display a single resource.
     * 
     * @param  App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return Response::item($product, $this->transformer);
    }
}
