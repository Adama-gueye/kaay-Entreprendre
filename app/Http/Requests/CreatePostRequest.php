<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreatePostRequest extends FormRequest
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
            'titre' => ['required', 'string'],
            'secteurActivite' => ['required', 'string'],
            'contenu' => ['required', 'string'],
        ];
    }

    public function withValidator($validator)
    {
         $validator->after(function ($validator) {
            $this->merge([
                'user_id' => auth()->user()->id,
            ]);
        });
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' =>true,
            'message' => 'Erreur de validation',
            'errorsList' => $validator->errors()
        ]));
    }

    public function messages(){
        return [
            'titre.required' => 'Le titre doit être fourni',
            'secteurActivite.required' => 'Le secteurActivite doit être fournie',
            'contenu.required' => 'Le contenu doit être fournie',
        ];
    }
}
