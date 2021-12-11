<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'number'                    => 'required',
            'temperature'               => 'required',
            'sample_type'               => 'required',
            'order_number'              => 'required',
            'country_id'                => 'required',
            'package_id'                => 'required',
            'weight'                    => 'required',
            'production_date'           => 'required',
            'expire_date'               => 'required',
            'release_date'              => auth()->user()->hasRole('Manager') ? 'required' : '',
            'customer'                  => 'required'
        ];
    }
}
