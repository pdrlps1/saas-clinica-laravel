<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name'=>[
                'required',
                'string',
                'max:255'
            ],
            'email'=>[
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'password'=>[
                'required',
                'string',
                'confirmed',
                Password::min(8)->letters()->numbers()
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto.',
            'name.max' => 'O nome deve ter no máximo 255 caracteres.',
            
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser um endereço válido.',
            'email.max' => 'O email deve ter no máximo 255 caracteres.',
            'email.unique' => 'Este email já está cadastrado.',
            
            'password.required' => 'A senha é obrigatória.',
            'password.confirmed' => 'As senhas não conferem.',
        ];
    }
}
