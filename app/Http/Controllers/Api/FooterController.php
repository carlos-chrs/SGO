<?php

namespace App\Http\Controllers\Api;

use App\Models\Footer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FooterController
{
    public function index(): JsonResponse
    {
        $footers = Footer::all();

        if ($footers->isEmpty()) {
            return response()->json([
                'message' => 'No hay footers para mostrar',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Footers obtenidos exitosamente',
            'data' => $footers
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'alto' => 'required|numeric',
            'ancho' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $footer = Footer::create($validator->validated());

        return response()->json([
            'message' => 'Footer creado exitosamente',
            'data' => $footer
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $footer = Footer::find($id);

        if (!$footer) {
            return response()->json([
                'message' => 'Footer no encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Footer encontrado',
            'data' => $footer
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $footer = Footer::find($id);

        if (!$footer) {
            return response()->json([
                'message' => 'Footer no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:255',
            'url' => 'sometimes|string|max:255',
            'alto' => 'sometimes|numeric',
            'ancho' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $footer->fill($validator->validated());
        $footer->save();

        return response()->json([
            'message' => 'Footer actualizado exitosamente',
            'data' => $footer
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $footer = Footer::find($id);

        if (!$footer) {
            return response()->json([
                'message' => 'Footer no encontrado'
            ], 404);
        }

        $footer->delete();

        return response()->json([
            'message' => 'Footer eliminado exitosamente'
        ], 200);
    }
}
