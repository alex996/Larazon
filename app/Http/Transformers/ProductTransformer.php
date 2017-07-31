<?php

namespace App\Http\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param  Product  $product
     * @return array
     */
	public function transform(Product $product)
	{
	    return [
	        'name'        => $product->name,
            'slug'        => $product->slug,
	        'description' => $product->description,
            'price'       => (float) $product->price,
            'quantity'    => (int) $product->quantity,
	    ];
	}
}