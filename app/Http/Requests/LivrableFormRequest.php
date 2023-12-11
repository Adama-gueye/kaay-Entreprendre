<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class LivrableFormRequest extends FormRequest
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
            'livrable' => ['required', 'string'],
            // 'livrable' => ['required', 'mimes:jpeg,png,gif,webp,pdf,doc,docx,ppt,pptx,mp4,avi,mov'],
            'ressource_id' => ['required', 'integer'],
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
            'error' => true,
            'message' => 'Erreur de validation',
            'errorsList' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'livrable.required' => 'Le livrable ne doit pas être vide',
            'ressource_id.required' => 'Ce livrable nest attaché à aucun module',

        ];
    }
}
