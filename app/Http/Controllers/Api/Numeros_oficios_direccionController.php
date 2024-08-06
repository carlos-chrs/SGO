<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Numeros_oficios_direccion;
use Illuminate\Http\JsonResponse;

class Numeros_oficios_direccionController
{
    public function inicializarContador(): JsonResponse
    {
        $contador = Numeros_oficios_direccion::first();

        if (!$contador) {
            Numeros_oficios_direccion::create(['contador' => 0]);
            return response()->json([
                'message' => 'Contador de dirección inicializado en 0'
            ], 201);
        }

        return response()->json([
            'message' => 'El contador de dirección ya existe'
        ], 200);
    }

    public function incrementarContador(): JsonResponse
    {
        $contador = Numeros_oficios_direccion::firstOrFail();
        $contador->contador += 1;
        $contador->save();

        return response()->json([
            'message' => 'Contador de dirección incrementado',
            'valor_actual' => $contador->contador
        ], 200);
    }

    public function obtenerContador(): JsonResponse
    {
        $contador = Numeros_oficios_direccion::firstOrFail();

        return response()->json([
            'contador' => $contador->contador
        ], 200);
    }

    public function restablecerContador(): JsonResponse
    {
        $contador = Numeros_oficios_direccion::firstOrFail();
        $contador->contador = 0;
        $contador->save();

        return response()->json([
            'message' => 'Contador de dirección restablecido a 0'
        ], 200);
    }
}
