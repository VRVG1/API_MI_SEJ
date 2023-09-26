<?php

namespace App\Http\Controllers;

use App\Models\administrative_area_participants;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdministrativeAreaParticipantsController extends Controller
{
    public function create(): JsonResponse
    {
        // Al ser solo una base de datos de prueba, no tiene atributos
        // mas haya del id
        $result = administrative_area_participants::create();

        if (is_null($result))
            return response()->json([
                'message' => 'Error creando un administrative area participants'
            ], 500);
        return response()->json([
            'message' => 'Administrative area participants creado con exito',
        ], 200);
    }
}