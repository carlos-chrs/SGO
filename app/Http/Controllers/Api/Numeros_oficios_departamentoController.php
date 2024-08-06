<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Numeros_oficios_departamento;
use Illuminate\Http\JsonResponse;


class Numeros_oficios_departamentoController
{
    public function inicializarContador(): JsonResponse
    {
        $contador = Numeros_oficios_departamento::first();

        if (!$contador) {
            Numeros_oficios_departamento::create(['contador' => 0]);
            return response()->json([
                'message' => 'Contador inicializado en 0'
            ], 201);
        }

        return response()->json([
            'message' => 'El contador ya existe'
        ], 200);
    }

    public function incrementarContador(): JsonResponse
    {
        $contador = Numeros_oficios_departamento::firstOrFail();
        $contador->contador += 1;
        $contador->save();

        return response()->json([
            'message' => 'Contador incrementado',
            'valor_actual' => $contador->contador
        ], 200);
    }

    public function obtenerContador(): JsonResponse
    {
        $contador = Numeros_oficios_departamento::firstOrFail();

        return response()->json([
            'contador' => $contador->contador
        ], 200);
    }

    public function restablecerContador(): JsonResponse
    {
        $contador = Numeros_oficios_departamento::firstOrFail();
        $contador->contador = 0;
        $contador->save();

        return response()->json([
            'message' => 'Contador restablecido a 0'
        ], 200);
    }
}
