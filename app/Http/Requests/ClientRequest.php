<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => '',
            'addr' => '',
            'comment' => ''
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'обязательно для заполнения',
            'phone.required' => 'обязательно для заполнения',
            //'phone.unique' => 'клиент с таким номером уже существует',
        ];
    }
}
