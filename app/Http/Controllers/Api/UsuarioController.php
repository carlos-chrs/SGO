<?php

namespace App\Http\Controllers\Api;

use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class UsuarioController
{
    public function index(): JsonResponse
    {
        $usuarios = Usuario::all();

        if ($usuarios->isEmpty()) {
            return response()->json([
                'message' => 'No hay usuarios para mostrar',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Usuarios obtenidos exitosamente',
            'data' => $usuarios
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'usuario' => 'required|string|max:255|unique:usuario,usuario',
            'password' => 'required|string|min:6',
            'acronimo' => 'required|string|max:255',
            'id_departamento' => 'required|integer',
            'permisos' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $usuario = Usuario::create($validator->validated());

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'data' => $usuario
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Usuario encontrado',
            'data' => $usuario
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:255',
            'usuario' => ['sometimes', 'string', 'max:255', Rule::unique('usuario')->ignore($id)],
            'password' => 'sometimes|string|min:6',
            'acronimo' => 'sometimes|string|max:255',
            'id_departamento' => 'sometimes|integer',
            'permisos' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $usuario->fill($validator->validated());
        $usuario->save();

        return response()->json([
            'message' => 'Usuario actualizado exitosamente',
            'data' => $usuario
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        $usuario->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente'
        ], 200);
    }

    public function searchByName(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $nombre = $request->input('nombre');

        $usuarios = Usuario::whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($nombre) . '%'])->get();

        if ($usuarios->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron usuarios con ese nombre',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Usuarios encontrados',
            'data' => $usuarios
        ], 200);
    }
}
