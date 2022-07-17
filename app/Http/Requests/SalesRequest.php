<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class SalesRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            '*.product_id' => 'required',
            '*.variant_id' => 'nullable',
            '*.qty' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response([
            'success' => false,
            'message' => $validator->errors(),
        ], 422);

        throw new ValidationException($validator, $response);
    }    
}
