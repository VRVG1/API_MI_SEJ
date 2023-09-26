<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventMailRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Models\events;
use App\Helpers\MakePDF;

class EventMailController extends Controller
{
    /**
     * Recive el id de un evento para enviarlo a un correo
     * @param int $id Id del evento que se desea enviar.
     * @return JsonResponse|mixed
     */
    public function sendEventToEmail(EventMailRequest $request)
    {

        Log::channel('events')->info('Entra a sendEventToEmail de events, con los datos:');
        Log::channel('events')->info(implode(', ', array_keys($request->all())));
        Log::channel('events')->info(implode(', ', $request->all()));
        $event = events::find($request->id);
        if (is_null($event)) {
            Log::channel('events')->error('Evento no encontrado');
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }
        $path = MakePDF::generate($event);
        Log::channel('events')->info('Evento listo para enviar');
        Mail::to($request->email)->send(new SendMail($event, $path));
        Log::channel('events')->info('Evento enviado correctamente');
        Log::channel('events')->info('Se elimina el archivo PDF');
        unlink($path);
        return response()->json("Evento enviado correctamente", 200);
    }
}