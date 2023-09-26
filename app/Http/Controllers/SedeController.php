<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\sede;

class SedeController extends Controller
{
    /**
     * Metodo que crea una sede sin ningun atributo
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(): JsonResponse
    {
        // No se necesitan validar datos, ya que solo se crea una sede
        // con un id auto incrementable
        $result = sede::create();
        if (is_null($result))
            return response()->json([
                'message' => 'Error al crear la sede'
            ], 500);
        return response()->json([
            "message" => "Sede creada correctamente"
        ], 200);
    }
}