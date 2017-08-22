<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->carts()->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->user();

        return [
            'card' => 'required|exists:cards,uid,user_id,'.$user->id,
            'address' => 'required|exists:addresses,uid,user_id,'.$user->id
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    /*public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Check all products are in stock
            // if ($this->somethingElseIsInvalid()) {
            //     $validator->errors()->add('field', 'Something is wrong with this field!');
            // }
        });
    }*/
}
