<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Http\Transformers\CategoryTransformer;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * @param ProductTransformer $transformer
     */
    public function __construct(CategoryTransformer $transformer)
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
        $categories = Category::paginate(50);

        return Response::paginator($categories, $this->transformer);
    }
}
