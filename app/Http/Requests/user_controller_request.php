<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class user_controller_request extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     * @var bool
     */
    protected $stopOnFirstFailure = false;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages(): array
    {
        return [
            // Mensajes en ingles
            // Name messages
            'name.required' => ["Required name", "Nombre requerido"],
            'name.string' => ['Name must be a string', 'Nombre debe ser un string'],
            'name.max' => ['Name must be less than 255 characters', 'Nombre debe ser menor a 255 caracteres'],
            // Email messages
            'email.required' => ['Required email', 'Email requerido'],
            'email.string' => ['Email must be a string', 'Email debe ser un string'],
            'email.email' => ['Email must be a valid email', 'Email debe ser un email válido'],
            'email.max' => ['Email must be less than 255 characters', 'Email debe ser menor a 255 caracteres'],
            'email.unique' => ['Email already exists', 'Email ya existe'],
            // Password messages
            'password.required' => ['Required password', 'Contraseña requerida'],
            'password.string' => ['Password must be a string', 'Contraseña debe ser un string'],
            'password.min' => ['Password must be at least 6 characters', 'Contraseña debe ser de al menos 6 caracteres'],
            // Role messages
            'role.required' => ['Required role', 'Rol requerido'],
            'role.string' => ['Role must be a string', 'Rol debe ser un string'],
        ];
    }
}