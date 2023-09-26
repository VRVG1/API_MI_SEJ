<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Yes_No;
use App\Enums\Type_event;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Log;

class Events_Request extends FormRequest
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
        Log::channel('events')->info('Entro a la validacion de eventos');
        return [
            'name_event' => 'required|string',
            'type_event' => ['required', new Enum(Type_event::class)],
            'group_event' => ['required', new Enum(Yes_No::class)],
            'date_register' => 'required|date',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'hour_start' => 'required|date',
            'hour_end' => 'required|date',
            'register_start_date' => 'required|date',
            'register_end_date' => 'required|date',
            'description_event' => 'required|string',
            'sede_id' => 'required|integer',
            'aquien_va_dirigido' => 'required|json',
            'director_CT_only' => ['required', new Enum(Yes_No::class)],
            'administrative_area_only' => ['required', new Enum(Yes_No::class)],
            'administrative_area_participants_id' => 'required|integer',
            'workplace_center_participants_id' => 'required|integer',
            'event_host' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'visible_data_host' => 'required|string',
            'asigned_host' => 'required|string',
            'have_event_activity' => ['required', new Enum(Yes_No::class)],
            'notification_enabled' => ['required', new Enum(Yes_No::class)],
            'thumbnail' => 'required|mimes:png,jpg,jpeg|max:2048',
            'files' => 'required|mimes:pdf,docx,xlsx,pptx,txt|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages(): array
    {
        Log::channel('events')->error('Error en la validacion de eventos');
        return [
            'name_event.required' => ['es' => "El nombre del evento es obligatorio", 'en' => "The event name is required"],
            'name_event.string' => ['es' => "El nombre del evento debe ser una cadena de texto", 'en' => "The event name must be a string"],
            'type_event.required' => ['es' => "El tipo de evento es obligatorio", 'en' => "The event type is required"],
            'type_event.enum' => ['es' => "El tipo de evento debe ser uno de los siguientes valores: " . Type_event::getValues(), 'en' => "The event type must be one of the following values: " . Type_event::getValues()],
            'group_event.required' => ['es' => "El grupo de evento es obligatorio", 'en' => "The group event is required"],
            'group_event.enum' => ['es' => "El grupo de evento debe ser uno de los siguientes valores: " . Yes_No::getValues(), 'en' => "The group event must be one of the following values: " . Yes_No::getValues()],
            'date_register.required' => ['es' => "La fecha de registro es obligatoria", 'en' => "The date register is required"],
            'date_register.date' => ['es' => "La fecha de registro debe ser una fecha válida", 'en' => "The date register must be a valid date"],
            'date_start.required' => ['es' => "La fecha de inicio es obligatoria", 'en' => "The date start is required"],
            'date_start.date' => ['es' => "La fecha de inicio debe ser una fecha válida", 'en' => "The date start must be a valid date"],
            'date_end.required' => ['es' => "La fecha de fin es obligatoria", 'en' => "The date end is required"],
            'date_end.date' => ['es' => "La fecha de fin debe ser una fecha válida", 'en' => "The date end must be a valid date"],
            'hour_start.required' => ['es' => "La hora de inicio es obligatoria", 'en' => "The hour start is required"],
            'hour_start.date' => ['es' => "La hora de inicio debe ser una fecha válida", 'en' => "The hour start must be a valid date"],
            'hour_end.required' => ['es' => "La hora de fin es obligatoria", 'en' => "The hour end is required"],
            'hour_end.date' => ['es' => "La hora de fin debe ser una fecha válida", 'en' => "The hour end must be a valid date"],
            'register_start_date.required' => ['es' => "La fecha de inicio de registro es obligatoria", 'en' => "The date register start is required"],
            'register_start_date.date' => ['es' => "La fecha de inicio de registro debe ser una fecha válida", 'en' => "The date register start must be a valid date"],
            'register_end_date.required' => ['es' => "La fecha de fin de registro es obligatoria", 'en' => "The date register end is required"],
            'register_end_date.date' => ['es' => "La fecha de fin de registro debe ser una fecha válida", 'en' => "The date register end must be a valid date"],
            'description_event.required' => ['es' => "La descripción del evento es obligatoria", 'en' => "The event description is required"],
            'description_event.string' => ['es' => "La descripción del evento debe ser una cadena de texto", 'en' => "The event description must be a string"],
            'sede_id.required' => ['es' => "La sede es obligatoria", 'en' => "The sede is required"],
            'sede_id.integer' => ['es' => "La sede debe ser un nÃ®mero entero", 'en' => "The sede must be an integer"],
            'aquien_va_dirigido.required' => ['es' => "A quién va dirigido es obligatorio", 'en' => "To whom is directed is required"],
            'aquien_va_dirigido.json' => ['es' => "A quién va dirigido debe ser una cadena de texto", 'en' => "To whom is directed must be a string"],
            'director_CT_only.required' => ['es' => "El director CT es obligatorio", 'en' => "The director CT is required"],
            'director_CT_only.enum' => ['es' => "El director CT debe ser uno de los siguientes valores: " . Yes_No::getValues(), 'en' => "The director CT must be one of the following values: " . Yes_No::getValues()],
            'administrative_area_only.required' => ['es' => "El área administrativa es obligatoria", 'en' => "The administrative area is required"],
            'administrative_area_only.enum' => ['es' => "El área administrativa debe ser uno de los siguientes valores: " . Yes_No::getValues(), 'en' => "The administrative area must be one of the following values: " . Yes_No::getValues()],
            'administrative_area_participants_id.required' => ['es' => "El id de la área administrativa es obligatorio", 'en' => "The id of the administrative area is required"],
            'administrative_area_participants_id.integer' => ['es' => "El id de la área administrativa debe ser un nÃ®mero entero", 'en' => "The id of the administrative area must be an integer"],
            'workplace_center_participants_id.required' => ['es' => "El id del centro de trabajo es obligatorio", 'en' => "The id of the workplace center is required"],
            'workplace_center_participants_id.integer' => ['es' => "El id del centro de trabajo debe ser un nÃ®mero entero", 'en' => "The id of the workplace center must be an integer"],
            'event_host.required' => ['es' => "El nombre del evento es obligatorio", 'en' => "The event name is required"],
            'event_host.string' => ['es' => "El nombre del evento debe ser una cadena de texto", 'en' => "The event name must be a string"],
            'email.required' => ['es' => "El email es obligatorio", 'en' => "The email is required"],
            'email.email' => ['es' => "El email debe ser una dirección de correo válida", 'en' => "The email must be a valid email"],
            'phone_number.required' => ['es' => "El nÃ®mero de telÃ©fono es obligatorio", 'en' => "The phone number is required"],
            'phone_number.string' => ['es' => "El nÃ®mero de telÃ©fono debe ser una cadena de texto", 'en' => "The phone number must be a string"],
            'data_host.required' => ['es' => "La data del host es obligatoria", 'en' => "The data host is required"],
            'data_host.string' => ['es' => "La data del host debe ser una cadena de texto", 'en' => "The data host must be a string"],
            'files.required' => ['es' => "El archivo es obligatorio", 'en' => "The file is required"],
            'files.max' => ['es' => "El archivo no debe superar los 2MB", 'en' => "The file must not exceed 2MB"],
            'files.mimes' => ['es' => "El archivo debe ser de tipo pdf, docx, xlsx, pptx, txt", 'en' => "The file must be of type pdf, docx, xlsx, pptx, txt"],
            'thumbnail.required' => ['es' => "La miniatura es obligatoria", 'en' => "The thumbnail is required"],
            'thumbnail.max' => ['es' => "La miniatura no debe superar los 2MB", 'en' => "The thumbnail must not exceed 2MB"],
            'thumbnail.mimes' => ['es' => "La miniatura debe ser de tipo png, jpg, jpeg", 'en' => "The thumbnail must be of type png, jpg, jpeg"]
        ];
    }
}