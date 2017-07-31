<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Transformers\CategoryTransformer;

class CategoryController extends Controller
{
    /**
     * Transformer.
     * 
     * @var CategoryTransformer
     */
    protected $transformer;
    
    /**
     * Create a new controller instance.
     * 
     * @param CategoryTransformer $transformer
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
