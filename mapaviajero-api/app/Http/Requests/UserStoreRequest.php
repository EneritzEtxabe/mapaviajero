<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'telefono' => 'nullable|numeric|digits:9|unique:users,telefono',
            'dni' => 'nullable|regex:/^\d{8}[A-HJ-NP-TV-Z]$/i|unique:users,dni',
            'rol' => 'sometimes|in:superadmin,admin,cliente',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'Introduce tu nombre.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.unique' => 'Ya existe un usuario con ese correo electrónico.',
            'password.required' => 'Introduce una contraseña.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'telefono.numeric' => 'El teléfono debe contener solo números.',
            'telefono.digits' => 'El teléfono debe tener exactamente 9 dígitos.',
            'telefono.unique' => 'Ya existe un usuario con ese número de teléfono.',
            'dni.regex' => 'El DNI debe tener un formato válido (8 números + letra).',
            'dni.unique' => 'Ya existe un usuario con ese DNI.',
            'rol.in' => 'El rol seleccionado no es válido.',
        ];
    }
}