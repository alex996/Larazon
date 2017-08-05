<?php

namespace App\Http\Requests\CartProduct;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'slug' => 'required|max:255|exists:products',
            'quantity' => 'required|integer|min:1'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if ($validator->passes()) {
            $validator->after(function ($validator) {                
                $cart = $this->route('cart');
                $product = Product::whereSlug($this->slug)->first();

                if ($cart->products()->where('products.id', $product->id)->exists()) {
                    $validator->errors()->add('slug', 'The selected product is already in the cart.');
                }
                else if ($this->quantity > $product->quantity) {
                    $validator->errors()->add('quantity', 'The selected quantity is invalid.');
                }                        
            });
        } 
    }
}
