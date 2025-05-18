<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;

class Etape2RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'tel' => 'required|digits:8|numeric|exists:users,tel',
            'code' => 'required|digits:6|numeric',
        ];
    }

    public function messages()
    {
        return [
            'tel.exists' => 'Ce numéro de téléphone n\'est pas enregistré.',
            'code.required' => 'Le code est obligatoire',
            'code.digits' => 'Le code doit contenir 6 chiffres.',
        ];
    }
}
