<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Transformers\ProductTransformer;

use League\Fractal\Resource\Collection;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;


class ProductController extends Controller
{
    public function __construct(Manager $fractal, ProductTransformer $transformer)
    {
        $this->fractal = $fractal;
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        $products = new Collection($products, $this->transformer);

        $products = $this->fractal->createData($products)->toArray();

        dd($products);
    }
}
