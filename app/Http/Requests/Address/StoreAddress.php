<?php

namespace App\Http\Requests\Address;

use App\Repositories\GeoRepository;
use Illuminate\Foundation\Http\FormRequest;

class StoreAddress extends FormRequest
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
    public function rules(GeoRepository $geo)
    {
        return [
            'type' => 'required|string|in:shipping,billing',
            'street' => 'required|string|max:255',
            'street_2' => 'nullable|string|max:255',            
            'city' => 'required|string|max:255',
            'state' => 'required|in:'.$geo->getStateCodesWithCommas(
                $this->get('country', 'US')
            ),
            'country' => 'required|in:'.$geo->getCountryCodesWithCommas(),
            'zip' => 'required|string|max:6|alphanum',    
        ];
    }
}
