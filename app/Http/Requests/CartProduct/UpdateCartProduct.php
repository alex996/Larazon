<?php

namespace App\Http\Requests\CartProduct;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UpdateCartProduct extends FormRequest
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
                $quantityInStock = $this->cartProduct->quantity;
                $quantityInCart = $this->cartProduct->pivot->quantity;

                if ($this->quantity > $quantityInStock || $this->quantity == $quantityInCart) {
                    $validator->errors()->add('quantity', 'The selected quantity is invalid.');
                }
            });
        }
    }
}
