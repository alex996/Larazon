<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Http\Transformers\ProductTransformer;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * @param ProductTransformer $transformer
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

    public function show(Product $product)
    {
        return Response::item($product, $this->transformer);
    }
}
