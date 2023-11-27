<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'type' => [
                'required',
                'string',
                'max:20',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::user()->document_number, 'document_number'),
            ],
            'password' => [
                'max:45',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'document_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore(Auth::user()->document_number, 'document_number'),
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'last_name' => 'Apellido',
            'type' => 'Rol',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
            'password_confirmation' => 'Confirmación de contraseña',
            'document_number' => 'Número de documento',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo :attribute es obligatorio',
            'name.string' => 'El campo :attribute debe ser una cadena de texto',
            'name.max' => 'El campo :attribute no puede tener más de :max caracteres',
            'last_name.required' => 'El campo :attribute es obligatorio',
            'last_name.string' => 'El campo :attribute debe ser una cadena de texto',
            'last_name.max' => 'El campo :attribute no puede tener más de :max caracteres',
            'type.required' => 'El campo :attribute es obligatorio',
            'type.string' => 'El campo :attribute debe ser una cadena de texto',
            'type.max' => 'El campo :attribute no puede tener más de :max caracteres',
            'email.required' => 'El campo :attribute es obligatorio',
            'email.email' => 'Por favor, introduce un :attribute válido',
            'email.max' => 'El :attribute no puede tener más de :max caracteres',
            'email.unique' => 'El :attribute ya está en uso',
            'document_number.unique' => 'El :attribute ya está en uso',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.mixed_case' => 'La contraseña debe contener al menos una letra mayúscula y una minúscula.',
            'password.numbers' => 'La contraseña debe contener al menos un número.',
            'password.symbols' => 'La contraseña debe contener al menos un símbolo.',
            'password.uncompromised' => 'La contraseña no es segura. Por favor, use una contraseña diferente.',
            'document_number.required' => 'El campo :attribute es obligatorio',
            'document_number.string' => 'El campo :attribute debe ser una cadena de texto',
            'document_number.max' => 'El campo :attribute no puede tener más de :max caracteres',
        ];
    }
}
