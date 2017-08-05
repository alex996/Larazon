<?php

namespace App\Http\Requests\CartProduct;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class DestroyCartProduct extends FormRequest
{
    protected $cartProduct;

    /**
     * Validate the class instance.
     *
     * @return void
     */
    public function validate()
    {
        $cart = $this->route('cart');
        $product = $this->route('product');

        $this->cartProduct = $cart->products()->findOrFail($product->id);

        parent::validate();
    }

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
            //
        ];
    }
}
