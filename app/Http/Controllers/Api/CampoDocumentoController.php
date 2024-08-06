<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CampoDocumento;
use Illuminate\Http\JsonResponse;

class CampoDocumentoController
{
    public function index(): JsonResponse
    {
        $camposDocumento = CampoDocumento::all();

        if ($camposDocumento->isEmpty()) {
            return response()->json([
                'message' => 'No hay elementos para mostrar',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Elementos obtenidos exitosamente',
            'data' => $camposDocumento
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'alineacion' => 'required|string|max:255',
            'text' => 'required|string',
            'id_fuente' => 'required|integer',
            'size' => 'required|integer',
            'isBold' => 'required|boolean',
            'isUnderline' => 'required|boolean',
            'nombreVisible' => 'required|boolean|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $campoDocumento = CampoDocumento::create($validator->validated());

        return response()->json([
            'message' => 'Campo de documento creado exitosamente',
            'data' => $campoDocumento
        ], 201);
    }
    public function show($id): JsonResponse
    {
        $campoDocumento = CampoDocumento::find($id);

        if (!$campoDocumento) {
            return response()->json([
                'message' => 'Campo de documento no encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Campo de documento encontrado',
            'data' => $campoDocumento
        ], 200);
    }
    public function destroy($id): JsonResponse
    {
        $campoDocumento = CampoDocumento::find($id);

        if (!$campoDocumento) {
            return response()->json([
                'message' => 'Campo de documento no encontrado'
            ], 404);
        }

        $campoDocumento->delete();

        return response()->json([
            'message' => 'Campo de documento eliminado exitosamente'
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $campoDocumento = CampoDocumento::find($id);

        if (!$campoDocumento) {
            return response()->json([
                'message' => 'Campo de documento no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:255',
            'alineacion' => 'sometimes|string|max:255',
            'text' => 'sometimes|string',
            'id_fuente' => 'sometimes|integer',
            'size' => 'sometimes|integer',
            'isBold' => 'sometimes|boolean',
            'isUnderline' => 'sometimes|boolean',
            'nombreVisible' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $campoDocumento->fill($validator->validated());
        $campoDocumento->save();

        return response()->json([
            'message' => 'Campo de documento actualizado exitosamente',
            'data' => $campoDocumento
        ], 200);
    }
}
