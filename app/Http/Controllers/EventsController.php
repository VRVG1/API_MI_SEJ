<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events_Request;
use App\Models\events;
use Illuminate\Http\JsonResponse;
use Storage;
use Illuminate\Support\Facades\Log;

class EventsController extends Controller
{
    /**
     * Crea un nuevo evento y lo guarda en la base de datos
     * @param \Illuminate\Http\Request $request datos del evento.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Events_Request $request): JsonResponse
    {
        Log::channel('events')->info('Entra a store de events');
        $events = new events();

        $file_name_thumbnail = time() . '_' . $request->file('thumbnail')->getClientOriginalName();

        $file_name_files = time() . '_' . $request->file('files')->getClientOriginalName();

        $file_path_thumbnail = $request->file('thumbnail')->storeAs('events', $file_name_thumbnail);

        $file_path_files = $request->file('files')->storeAs('events', $file_name_files);

        $events->name_event = $request->name_event;
        $events->type_event = $request->type_event;
        $events->group_event = $request->group_event;
        $events->date_register = $request->date_register;
        $events->date_start = $request->date_start;
        $events->date_end = $request->date_end;
        $events->hour_start = $request->hour_start;
        $events->hour_end = $request->hour_end;
        $events->register_start_date = $request->register_start_date;
        $events->register_end_date = $request->register_end_date;
        $events->description_event = $request->description_event;
        $events->sede_id = $request->sede_id;
        $events->aquien_va_dirigido = $request->aquien_va_dirigido;
        $events->director_CT_only = $request->director_CT_only;
        $events->administrative_area_only = $request->administrative_area_only;
        $events->administrative_area_participants_id = $request->administrative_area_participants_id;
        $events->workplace_center_participants_id = $request->workplace_center_participants_id;
        $events->event_host = $request->event_host;
        $events->email = $request->email;
        $events->phone_number = $request->phone_number;
        $events->visible_data_host = $request->visible_data_host;
        $events->asigned_host = $request->asigned_host;
        $events->have_event_activity = $request->have_event_activity;
        $events->notification_enabled = $request->notification_enabled;
        $events->thumbnail = $file_path_thumbnail;
        $events->files = $file_path_files;
        Log::channel('events')->info('Datos a crear evento: ', $request->all());
        // Guardamos el evento
        $events->save();
        Log::channel('events')->info('Evento creado correctamente');
        return response()->json(['message' => 'Evento creado correctamente'], 200);
    }

    /**
     * Obtiene un evento por su ID.
     * @param int $id El ID del evento que se desea obtener.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        Log::channel('events')->info('Entra a show de events');
        $event = events::find($id);
        if (is_null($event)) {
            Log::channel('events')->error('Evento no encontrado');
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        Log::channel('events')->info('Evento encontrado: ' . $event);
        return response()->json($event, 200);
    }

    /**
     * Obtiene todos los eventos.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        Log::channel('events')->info('Entra a index de events');
        $events = events::paginate(10);
        if (is_null($events)) {
            Log::channel('events')->error('No hay eventos');
            return response()->json(['message' => 'No hay eventos'], 404);
        }
        Log::channel('events')->info('Eventos encontrados');
        return response()->json($events, 200);
    }

    /**
     * Elimina un evento por su ID.
     * @param int $id El ID del evento que se desea eliminar.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        Log::channel('events')->info('Entra a destroy de events');
        $event = events::find($id);
        if (is_null($event)) {
            Log::channel('events')->error('Evento no encontrado');
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }
        Log::channel('events')->info('Evento encontrado: ' . $event);
        $event->delete();
        Log::channel('events')->info('Evento eliminado correctamente');
        return response()->json(['message' => 'Evento eliminado correctamente'], 200);
    }

    /**
     * Actualiza un evento por su ID.
     * @param \Illuminate\Http\Request $request El request con los datos del evento.
     * @param int $id El ID del evento que se desea actualizar.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Events_Request $request, int $id): JsonResponse
    {
        Log::channel('events')->info('Entra a update de events');
        $event = events::find($id);
        if (is_null($event)) {
            Log::channel('events')->error('Evento no encontrado');
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }
        Log::channel('events')->info('Evento encontrado: ' . $event);
        # Eliminando los archivos que ya entan guardados
        $files = array($event->thumbnail, $event->files);
        Storage::delete($files);
        # Creando nuevos archivos
        $file_name_thumbnail = time() . '_' . $request->file('thumbnail')->getClientOriginalName();

        $file_name_files = time() . '_' . $request->file('files')->getClientOriginalName();

        $file_path_thumbnail = $request->file('thumbnail')->storeAs('events', $file_name_thumbnail);

        $file_path_files = $request->file('files')->storeAs('events', $file_name_files);

        $event->name_event = $request->name_event;
        $event->type_event = $request->type_event;
        $event->group_event = $request->group_event;
        $event->date_register = $request->date_register;
        $event->date_start = $request->date_start;
        $event->date_end = $request->date_end;
        $event->hour_start = $request->hour_start;
        $event->hour_end = $request->hour_end;
        $event->register_start_date = $request->register_start_date;
        $event->register_end_date = $request->register_end_date;
        $event->description_event = $request->description_event;
        $event->sede_id = $request->sede_id;
        $event->aquien_va_dirigido = $request->aquien_va_dirigido;
        $event->director_CT_only = $request->director_CT_only;
        $event->administrative_area_only = $request->administrative_area_only;
        $event->administrative_area_participants_id = $request->administrative_area_participants_id;
        $event->workplace_center_participants_id = $request->workplace_center_participants_id;
        $event->event_host = $request->event_host;
        $event->email = $request->email;
        $event->phone_number = $request->phone_number;
        $event->visible_data_host = $request->visible_data_host;
        $event->asigned_host = $request->asigned_host;
        $event->have_event_activity = $request->have_event_activity;
        $event->notification_enabled = $request->notification_enabled;
        $event->thumbnail = $file_path_thumbnail;
        $event->files = $file_path_files;
        // Guadamos el evento
        Log::channel('events')->info('Datos a actualizar evento' . $event);
        $event->save();
        Log::channel('events')->info('Evento actualizado correctamente');
        return response()->json(['message' => 'Evento actualizado correctamente'], 200);
    }
}