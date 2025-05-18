<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'tel'=>'required|exists:users,tel',
            'code' => 'required',
        ];
    }
    public function messages(){
        return[
           'code.required' => 'Le code est obligatoire',
            'tel.required'=>'tel est obligatoire',
            'tel.exists'=>'tel nexiste pas',
        ];
    }
}
