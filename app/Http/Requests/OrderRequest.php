<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            //'client_id' => 'integer|required',
            //'status_id' => 'integer',
        ];
    }

    public function messages()
    {
        return [
            //'client_id.required' => 'обязательно для заполнения',
            //'client_id.integer' => 'нужна цифра',

        ];
    }
}
