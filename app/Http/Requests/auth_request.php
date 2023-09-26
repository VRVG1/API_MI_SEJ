<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class auth_request extends FormRequest
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
     * Get the 'after' validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (!auth()->attempt($validator->validated())) {
                    $validator->errors()->add('email', 'Email or password is invalid');
                }
            }
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages(): array
    {
        return [
            // Message de validacion en ingles y espanol
            'email.required' => ['es' => 'El correo electrónico es requerido', 'en' => 'Email is required'],
            'email.email' => ['es' => 'El correo electrónico es invalido', 'en' => 'Email is invalid'],
            'password.required' => ['es' => 'La contraseña es requerida', 'en' => 'Password is required'],
            'password.min' => ['es' => 'La contraseña debe tener al menos 6 caracteres', 'en' => 'Password must be at least 6 characters'],
            'password.string' => ['es' => 'La contraseña debe ser un string', 'en' => 'Password must be a string']
        ];
    }
}