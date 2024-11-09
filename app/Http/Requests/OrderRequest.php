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

            // string|nullable|required|unique:books,name|max:150
            // 'file|max:500'
            // 'integer|nullable|required|max:9999'

            /*
            client_id
            user_id
            status_id
            comment

            mm_model
            mm_model_size
            mm_material
            mm_details

            services
            deadline_date

            'mm_model' => 'integer|nullable',
            'mm_model_size' => 'string|nullable',
            'mm_material' => 'integer|nullable',
            'mm_details' => 'string|nullable',
            */

            'client_id' => 'integer|required',
            'user_id' => 'integer|required',
            'status_id' => 'integer|required',
            'comment' => 'string|nullable',

            'services' => '',
            'deadline_date' => 'string',

            'eskiz' => '',
            'client_file' => '',
            'price_list' => '',
            'estimate' => '',
            'payment' => '',
            'price' => '',
            'total_correct' => '',

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
