<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'phone' => 'required',
            'email' => '',
            'password' => '',
            'user_group' => '',
            'comment' => '',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'обязательно для заполнения',
            'phone.required' => 'обязательно для заполнения',

        ];
    }
}
