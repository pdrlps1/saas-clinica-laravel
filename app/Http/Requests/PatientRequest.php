<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            'name'=>'required|string|max:255',
            'email'=>'nullable|email|max:255',
            'phone'=>'nullable|string|max:20',
            'birthdate'=>'nullable|date|before:today',
        ];
    }
    
    public function messages(): array
        {
            return [
                'name.required'=>'O nome é obrigatório',
                'name.string'=>'O nome deve ser um texto',
                'name.max'=>'O nome deve ter no máximo 255 caracteres',
                'email.email'=>'O email deve ser um endereço válido.',
                'email.max'=>'O email deve ter no máximo 255 caracteres.',
                'phone.string'=>'O telefone deve ser um texto.',
                'phone.max'=>'O telefone deve ter no máximo 20 caracteres.',
                'birthdate.date'=>'A data de nascimento deve ser uma data válida.',
                'birthdate.before'=>'A data de nascimento deve ser anterior a hoje.',

            ];
        }
}
