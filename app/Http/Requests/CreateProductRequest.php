<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name.ar' => 'required',
            'name.en' => 'required',
            'name.fr' => 'sometimes',
            'name.de' => 'sometimes',
           

            'description.ar' => 'required',
            'description.en' => 'required',
            'description.fr' => 'sometimes',
            'description.de' => 'sometimes',
            'attachment' => 'required',

        ];
    }
}
