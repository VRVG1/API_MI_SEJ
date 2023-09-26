<?php

namespace App\Http\Controllers;

use App\Models\workplace_center_participants;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkplaceCenterParticipantsController extends Controller
{
    public function create(): JsonResponse
    {
        // Al ser solo una base de datos de prueba, no tiene atributos
        // mas haya del id
        $result = workplace_center_participants::create();

        if (is_null($result))
            return response()->json([
                'message' => 'Error creando un workplace center participants'
            ], 500);
        return response()->json([
            'message' => 'Workplace center participants creado con exito',
        ], 200);
    }
}