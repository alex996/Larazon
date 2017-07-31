<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    /**
     * Listen to the Product saving event.
     *
     * @param  Product  $product
     * @return void
     */
    public function saving(Product $product)
    {
        // If the name was changed, we need to sync it with the slug
        if ($product->isDirty('name')) {
            $slug = str_slug($product->name);

            if ($count = Product::where('slug', 'like', "$slug%")->count())
                $slug = str_finish($slug, "-$count");

            $product->slug = $slug;
        }
    }
}