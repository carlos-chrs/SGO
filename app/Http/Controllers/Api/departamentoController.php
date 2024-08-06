<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Departamento;


class departamentoController extends Controller
{
    public function index(){
        $response = Departamento::all();
        if($response->isEmpty()){
            $data = [
                'message' => 'no hay departamentos registrados',
            ];
            return response()->json($data, 200);
        }
        return response()->json($response, 200);

    }
    public function store(Request $request){
        $validacion = Validator::make($request->all(),[
            'nombre' => 'required|string|max:255|unique:departamento',
            'jefe' => 'required|string|max:255',
            'acronimo' => 'required|string|max:10|unique:departamento',

        ]);
        if($validacion->fails()){
            $data = [
                'message' => 'Error en la validación',
                'errors' => $validacion->errors(),
            ];
            return response()->json($data, 400);
        }
        $element = Departamento::create(
            [
                'nombre' => $request -> nombre,
                'jefe' => $request -> jefe,
                'acronimo' => $request -> acronimo,
            ]
        );

        if(!$element){
            $data = [
                'message' => 'Error al crear el departamento',
            ];
            return response()->json($data, 500);
        }
        $data = [
            'message' => 'Departamento creado con éxito',
            'departamento' => $element,
        ];
        return response()->json($data, 201,);
    }
    public function findById($id){
          $response = Departamento::find($id);
          if (!$response) {
              return response()->json([
                  'message' => 'Departamento no encontrado',
              ], 404);
          }
          return response()->json($response, 200);
    }
    public function findByName( $name ){
        // Search for documents using the partial ID
        $items = Departamento::whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($name) . '%'])->get();

        // Check if any documents were found
        if ($items->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron departamentos con ese nombre',
            ], 404);
        }

        // Return the matching documents
        return response()->json($items, 200);
    }
    public function delete($id){
        $response = Departamento::find($id);
        
        if (!$response) {
            return response()->json([
                'message' => 'Departamento no encontrado',
            ], 404);
        }

        $deletedItem = $response->toArray();
        $deleted = $response->delete();
        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Item eliminado con éxito',
                'deleted_item' => $deletedItem
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo eliminar el item'
            ], 500);
        }
        
        return response()->json($response, 200);
    }
}
