<?php

namespace App\Repositories\Product;

use App\Models\Product;

class EloquentProductRepository implements ProductRepository
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function paginate(int $perPage = 50)
    {
        return $this->product->paginate($perPage);
    }

    public function firstWhereSlug(string $slug)
    {
        return $this->product->where('slug', $slug)->first();
    }

    public function countWhereSlug(string $slug)
    {
        return $this->product->where('slug', 'like', "$slug%")->count();
    }
}