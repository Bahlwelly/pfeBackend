<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;

class NouveauPasswordRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'tel' => 'required|digits:8|numeric|exists:users,tel',
            'password' => 'required|min:4|confirmed',

        ];
    }
    public function messages(){
        return[
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 4 caractères.',
            'password_confirm.required' => 'La confirmation du mot de passe est obligatoire.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.', 
        ];
    }
}
