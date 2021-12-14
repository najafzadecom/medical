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

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'temperature.required'          => ' sahəsini doldurmaq zəruridir!',
            'sample_type.required'          => ' sahəsini doldurmaq zəruridir!',
            'order_number.required'         => ' sahəsini doldurmaq zəruridir!',
            'country_id.required'           => ' sahəsini doldurmaq zəruridir!',
            'package_id.required'           => ' sahəsini doldurmaq zəruridir!',
            'weight.required'               => ' sahəsini doldurmaq zəruridir!',
            'production_date.required'      => ' sahəsini doldurmaq zəruridir!',
            'expire_date.required'          => ' sahəsini doldurmaq zəruridir!',
            'release_date.required'         => ' sahəsini doldurmaq zəruridir!',
            'customer.required'             => ' sahəsini doldurmaq zəruridir!'
        ];
    }
}
