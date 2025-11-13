<?php

namespace App\Http\Requests;

use App\Enums\AppointmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentRequest extends FormRequest
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
        $rules = [
            'patient_id' => [
                'required',
                'integer',
                'exists:patients,id',
            ],
            'responsible_user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'starts_at' => [
                'required',
                'date_format:Y-m-d\TH:i', // Input type="datetime-local"
            ],
            'duration_min' => [
                'required',
                'integer',
                'min:15', // Mínimo 15 minutos
                'max:480', // Máximo 8 horas (480 min)
            ],
            'status' => [
                'required',
                Rule::enum(AppointmentStatus::class), // Valida contra Enum!
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000', // Limita tamanho das observações
            ],
        ];


        // Se for criação 'POST' permite data futura, se for edição 'PUT' ou 'PATCH' permite data passada.
        if ($this->isMethod('POST'))
        {
            $rules['starts_at'][]='after:now';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'O paciente é obrigatório.',
            'patient_id.integer' => 'O ID do paciente deve ser um número inteiro.',
            'patient_id.exists' => 'O paciente selecionado não existe.',
            
            'responsible_user_id.required' => 'O responsável é obrigatório.',
            'responsible_user_id.integer' => 'O ID do responsável deve ser um número inteiro.',
            'responsible_user_id.exists' => 'O responsável selecionado não existe.',
            
            'starts_at.required' => 'A data e hora de início são obrigatórias.',
            'starts_at.date_format' => 'A data e hora devem estar no formato correto (AAAA-MM-DDThh:mm).',
            'starts_at.after' => 'A consulta deve ser agendada para o futuro.',
            
            'duration_min.required' => 'A duração é obrigatória.',
            'duration_min.integer' => 'A duração deve ser um número inteiro de minutos.',
            'duration_min.min' => 'A duração deve ser de no mínimo 15 minutos.',
            'duration_min.max' => 'A duração deve ser de no máximo 8 horas (480 minutos).',
            
            'status.required' => 'O status é obrigatório.',
            'status.enum' => 'O status selecionado é inválido.',
            
            'notes.string' => 'As observações devem ser um texto.',
            'notes.max' => 'As observações devem ter no máximo 1000 caracteres.',
        ];
    }
}
