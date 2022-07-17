<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class ProductRequest extends FormRequest
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
            'name' => 'required|max:255',
            'price' => 'exclude_if:has_variant,false|required',
            'category_id' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response([
            'success' => false,
            'message' => $validator->errors(),
        ], 422);

        throw new ValidatorException($validator, $response);
    }
}
