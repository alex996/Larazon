<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Listen to the Category saving event.
     *
     * @param  Category  $category
     * @return void
     */
    public function saving(Category $category)
    {
        // If the name was changed, we need to sync it with the slug
        if ($category->isDirty('name')) {
            $category->slug = str_slug($category->name);
        }
    }
}