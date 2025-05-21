<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;

class Etape3RegisterRequest extends FormRequest
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
            'name' => 'required|string',
            'password' => 'required|min:4|max:4|confirmed', 
            'nni' => 'required|numeric|digits:10|unique:users,nni',
            'tel' => 'required|digits:8|numeric|exists:users,tel',
           
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 4 caractères.',
            'password.max' => 'Le mot de passe doit etre son max 4 caractères.',
            'password_confirm.required' => 'La confirmation du mot de passe est obligatoire.',
            'password.confirmed' => 'Les mots de passe ne conforme pas.', 
            'nni.required' => 'Le NNI est obligatoire.',
            'nni.unique' => 'Ce NNI est déjà enregistré.',
            'nni.digits' => 'Le NNI doit contenir exactement 10 chiffres.',
            'tel.exists' => 'Ce numéro de téléphone n\'est pas enregistré.',
            
            
        ];
    }
}
