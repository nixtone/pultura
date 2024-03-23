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
            'phone' => 'required|unique:users,phone',
            'email' => 'email|unique:users,email',
            'password' => 'required',
            'user_group' => 'required|integer',
            'comment' => '',
        ];
    }

    public function messages()
    {
        $message = [
            'required' => 'обязательно для заполнения'
        ];
        return [
            'name.required' => $message['required'],

            'phone.required' => $message['required'],
            'phone.unique' => 'такой номер уже занят',

            'email.unique' => 'такой E-mail уже занят',
            'email.email' => 'неправильный формат',

            'password.required' => $message['required'],

        ];
    }
}
