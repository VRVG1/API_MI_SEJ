<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class EventMailRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        Log::info('EventMailRequest Rules');
        return [
            'id' => 'required|integer',
            'email' => 'required|email',
        ];
    }

    public function messages(): array
    {
        Log::info('EventMailRequest Messages');
        return [
            'id.required' => ['es' => "El id del evento es obligatorio", 'en' => "The event id is required"],
            'id.integer' => ['es' => "El id del evento debe ser un entero", 'en' => "The event id must be an integer"],
            'email.required' => ['es' => "El email es obligatorio", 'en' => "The email is required"],
            'email.email' => ['es' => "El email no es válido", 'en' => "The email is not valid"],
        ];
    }
}