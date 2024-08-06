<?php

namespace App\Http\Controllers\Api;

use App\Models\Documento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentoController
{
    public function index(): JsonResponse
    {
        $documentos = Documento::all();

        if ($documentos->isEmpty()) {
            return response()->json([
                'message' => 'No hay documentos para mostrar',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Documentos obtenidos exitosamente',
            'data' => $documentos
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'text' => 'required|string',
            'creadoPor' => 'required|string|max:255',
            'header' => 'required|string',
            'footer' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $documento = Documento::create($validator->validated());

        return response()->json([
            'message' => 'Documento creado exitosamente',
            'data' => $documento
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $documento = Documento::find($id);

        if (!$documento) {
            return response()->json([
                'message' => 'Documento no encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Documento encontrado',
            'data' => $documento
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $documento = Documento::find($id);

        if (!$documento) {
            return response()->json([
                'message' => 'Documento no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'tipo' => 'sometimes|string|max:255',
            'numero' => 'sometimes|string|max:255',
            'text' => 'sometimes|string',
            'creadoPor' => 'sometimes|string|max:255',
            'header' => 'sometimes|string',
            'footer' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $documento->fill($validator->validated());
        $documento->save();

        return response()->json([
            'message' => 'Documento actualizado exitosamente',
            'data' => $documento
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $documento = Documento::find($id);

        if (!$documento) {
            return response()->json([
                'message' => 'Documento no encontrado'
            ], 404);
        }

        $documento->delete();

        return response()->json([
            'message' => 'Documento eliminado exitosamente'
        ], 200);
    }
    public function searchByNumero(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'numero' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $numero = $request->input('numero');

        $documentos = documento::whereRaw('LOWER(numero) LIKE ?', ['%' . strtolower($numero) . '%'])->get();

        if ($documentos->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron documentos con ese número',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Documentos encontrados',
            'data' => $documentos
        ], 200);
    }

}
