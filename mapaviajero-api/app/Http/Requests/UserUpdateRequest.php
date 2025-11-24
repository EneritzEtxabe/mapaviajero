<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $userId = $this->route('user');
        return [
            'nombre' => 'sometimes|string|max:255',
            'email' => ['sometimes','email',Rule::unique('users', 'email')->ignore($userId)],
            'password'=>'sometimes|string|min:8',
            'telefono' => ['nullable','numeric','digits:9', Rule::unique('users', 'telefono')->ignore($userId)],
            'dni' => ['nullable','regex:/^\d{8}[A-HJ-NP-TV-Z]$/i', Rule::unique('users', 'dni')->ignore($userId)],
            'rol'=>'sometimes|in:superadmin,admin,cliente',
        ];
    }

    public function messages(): array
    {
        return[
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',

            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.unique' => 'Ya existe un usuario con ese correo electrónico',

            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',

            'telefono.numeric' => 'El teléfono debe contener solo números.',
            'telefono.digits' => 'El teléfono debe tener exactamente 9 dígitos.',
            'telefono.unique' => 'Ya existe un usuario con ese número de teléfono.',

            'dni.regex' => 'El DNI debe tener un formato válido (8 números seguidos de una letra).',
            'dni.unique' => 'Ya existe un usuario con ese DNI.',

            'rol.in' => 'El rol seleccionado no es válido. Debe ser "superadmin" "admin" o "cliente".',
        ];
    }
}