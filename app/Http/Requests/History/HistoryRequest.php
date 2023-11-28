<?php

namespace App\Http\Requests\History;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HistoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'state_patient' => [
                'required',
            ],
            'health_history' => [
                'required',
            ],
            'patient_id' => ['required', 'min:1', 'max:45', Rule::exists('users', 'id')],
        ];
    }

    public function attributes()
    {
        return [
            'state_patient' => 'Estado del paciente',
            'health_history' => 'Antecedentes medicos',
            'patient_id' => 'Paciente',
        ];
    }

    public function messages()
    {
        return [
            'state_patient.required' => 'El campo :attribute es obligatorio',

            'health_history.required' => 'El campo :attribute es obligatorio',
        ];
    }
}
