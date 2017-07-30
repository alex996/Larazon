<?php

namespace App\Http\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param  Category  $category
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'slug' => $category->slug,
            'name' => $category->name,
        ];
    }
}