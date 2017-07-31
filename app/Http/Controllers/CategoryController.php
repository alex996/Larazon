<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Transformers\CategoryTransformer;
use App\Repositories\Category\CategoryRepository;

class CategoryController extends Controller
{
    protected $repository;

    protected $transformer;
    
    /**
     * Create a new controller instance.
     * 
     * @param ProductTransformer $transformer
     */
    public function __construct(CategoryRepository $repository, CategoryTransformer $transformer)
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
        $categories = $this->repository->paginate(50);

        return Response::paginator($categories, $this->transformer);
    }
}
