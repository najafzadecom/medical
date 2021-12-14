<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name'          => 'required',
            'username'      => 'required|unique:users',
            'password'      => 'required|min:9|confirmed'
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
            'name.required'         => 'Ad sahəsini doldurmaq zəruridir!',
            'username.required'     => 'İstifadəçi adı sahəsini doldurmaq zəruridir!',
            'username.unique'       => 'Bu istifadəçi adı ilə istifadəçi artıq bazada mövcuddur!',
            'password.required'     => 'Şifrə sahəsini doldurmaq zəruridir!',
            'password.min'          => 'Şifrə minimum 9 simvoldan ibarət olmalıdır doldurmaq zəruridir!',
            'password.confirmed'    => 'Şifrə onun təkrarı ilə eyni olmalıdır!'
        ];
    }
}
