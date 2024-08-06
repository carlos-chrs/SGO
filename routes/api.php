<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\departamentoController;
use App\Http\Controllers\Api\CampoDocumentoController;
use App\Http\Controllers\Api\DocumentoController;
use App\Http\Controllers\Api\FooterController;
use App\Http\Controllers\Api\HeaderController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\Numeros_oficios_departamentoController;
use App\Http\Controllers\Api\Numeros_oficios_direccionController;
use App\Http\Controllers\Api\PdfController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\FuenteController;

// rutas de departamentos
Route::get('/Departamentos', [departamentoController::class, 'index']);
Route::get('/Departamentos/nombre/{nombre}',  [departamentoController::class, 'findByName']);
Route::get('/Departamentos/{id}', [departamentoController::class, 'findById']);
Route::post('/Departamentos', [departamentoController::class, 'store']);
Route::delete('/Departamentos/{id}',  [departamentoController::class, 'delete']);


Route::get('/campos-documento', [CampoDocumentoController::class, 'index']);
Route::post('/campos-documento', [CampoDocumentoController::class, 'store']);
Route::get('/campos-documento/{id}', [CampoDocumentoController::class, 'show']);
Route::delete('/campos-documento/{id}', [CampoDocumentoController::class, 'destroy']);
Route::put('/campos-documento/{id}', [CampoDocumentoController::class, 'update']);

Route::get('/documentos', [DocumentoController::class, 'index']);
Route::post('/documentos', [DocumentoController::class, 'store']);
Route::get('/documentos/{id}', [DocumentoController::class, 'show']);
Route::put('/documentos/{id}', [DocumentoController::class, 'update']);
Route::delete('/documentos/{id}', [DocumentoController::class, 'destroy']);
Route::get('/documentos/search', [DocumentoController::class, 'searchByNumero']);

Route::get('/footers', [FooterController::class, 'index']);
Route::post('/footers', [FooterController::class, 'store']);
Route::get('/footers/{id}', [FooterController::class, 'show']);
Route::put('/footers/{id}', [FooterController::class, 'update']);
Route::delete('/footers/{id}', [FooterController::class, 'destroy']);

Route::get('/headers', [HeaderController::class, 'index']);
Route::post('/headers', [HeaderController::class, 'store']);
Route::get('/headers/{id}', [HeaderController::class, 'show']);
Route::put('/headers/{id}', [HeaderController::class, 'update']);
Route::delete('/headers/{id}', [HeaderController::class, 'destroy']);

Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);
Route::get('/usuarios/search', [UsuarioController::class, 'searchByName']);

Route::post('/contador/inicializar', [Numeros_oficios_departamentoController::class, 'inicializarContador']);
Route::post('/contador/incrementar', [Numeros_oficios_departamentoController::class, 'incrementarContador']);
Route::get('/contador', [Numeros_oficios_departamentoController::class, 'obtenerContador']);
Route::post('/contador/restablecer', [Numeros_oficios_departamentoController::class, 'restablecerContador']);


Route::post('/contador-direccion/inicializar', [Numeros_oficios_direccionController::class, 'inicializarContador']);
Route::post('/contador-direccion/incrementar', [Numeros_oficios_direccionController::class, 'incrementarContador']);
Route::get('/contador-direccion', [Numeros_oficios_direccionController::class, 'obtenerContador']);
Route::post('/contador-direccion/restablecer', [Numeros_oficios_direccionController::class, 'restablecerContador']);


Route::post('/pdf', [PdfController::class, 'crearPdf']);

Route::post('/images', [ImageController::class, 'store']);
Route::get('/images', [ImageController::class, 'index']);
Route::delete('/images/{type}/{filename}', [ImageController::class, 'destroy']);

Route::post('/fuentes', [FuenteController::class, 'store']);
Route::get('/fuentes', [FuenteController::class, 'index']);
Route::delete('/fuentes/{id}', [FuenteController::class, 'destroy']);