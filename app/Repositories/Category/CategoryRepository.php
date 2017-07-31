<?php

namespace App\Repositories\Category;

interface CategoryRepository
{
    public function paginate(int $perPage = 50);
}