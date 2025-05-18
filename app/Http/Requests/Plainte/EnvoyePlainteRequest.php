<?php

namespace App\Http\Requests\Plainte;

use Illuminate\Foundation\Http\FormRequest;

class EnvoyePlainteRequest extends FormRequest
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
        'details' => 'required|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        'adresse' => 'required|string',
        'commune' => 'required|string',
        ];
    }
     public function messages()
    {
        return [
             'image.required' => 'Veuillez uploader une image.',
            'image.image' => 'Le fichier doit être une image valide (jpeg, png, jpg, gif).',
            'image.mimes' => 'Format non autorisé. Seuls les fichiers jpeg, png, jpg et gif sont acceptés.',
            'image.max' => 'L\'image ne doit pas dépasser 2 Mo.',
            'adress.required' => 'ladress est obligatoire',
            'commune.required' => 'La commune est obligatoire',
            
        ];
    }
}
