<?php

namespace App\Repositories\Category;

use App\Models\Category;

class EloquentCategoryRepository implements CategoryRepository
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function paginate(int $perPage = 50)
    {
        return $this->category->paginate($perPage);
    }
}