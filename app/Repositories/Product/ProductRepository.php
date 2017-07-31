<?php

namespace App\Repositories\Product;

interface ProductRepository
{
    public function paginate(int $perPage = 50);

    public function firstWhereSlug(string $slug);

    public function countWhereSlug(string $slug);
}