<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
           'tel' => ['required', 'numeric', 'regex:/^[234][0-9]{7}$/', 'exists:users,tel'],
           'password' => ['required']

        ];
    }
    public function messages(){
       return [
            'tel.exists'=>'tel nexiste pas',
            'tel.required' => 'Le numéro de téléphone est obligatoire.',
            'tel.regex' => 'Le numéro de téléphone doit comporter 8 chiffres et commencer par 2, 3 ou 4.',
            'tel.numeric' => 'Le numéro doit être composé uniquement de chiffres.',
            'password'=>'password est obligatoire',
        ];
        }

}
