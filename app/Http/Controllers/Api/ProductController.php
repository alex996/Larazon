<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Http\Transformers\ProductTransformer;
use App\Repositories\Product\ProductRepository;

class ProductController extends Controller
{
    protected $repository;

    protected $transformer;

    /**
     * Create a new controller instance.
     * 
     * @param ProductTransformer $transformer
     */
    public function __construct(ProductRepository $repository, ProductTransformer $transformer)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->repository->paginate(50);

        return Response::paginator($products, $this->transformer);
    }

    public function show(Product $product)
    {
        return Response::item($product, $this->transformer);
    }
}
