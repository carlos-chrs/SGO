<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'type' => 'required|in:header,footer'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName = $request->input('name') . '.' . $extension;
            $path = $image->storeAs('public/images/' . $request->input('type'), $fileName);
            
            return response()->json(['message' => 'Image uploaded successfully', 'path' => $path]);
        }

        return response()->json(['message' => 'No image file uploaded'], 400);
    }

    public function index(Request $request)
    {
        $type = $request->query('type', 'all');
        
        if ($type === 'header') {
            $images = Storage::files('public/images/header');
        } elseif ($type === 'footer') {
            $images = Storage::files('public/images/footer');
        } else {
            $headerImages = Storage::files('public/images/header');
            $footerImages = Storage::files('public/images/footer');
            $images = array_merge($headerImages, $footerImages);
        }

        return response()->json($images);
    }

    public function show(Request $request, $type, $filename)
    {
        if (!in_array($type, ['header', 'footer'])) {
            return response()->json(['message' => 'Tipo de imagen no válido'], 400);
        }

        $path = "public/images/{$type}/{$filename}";

        if (!Storage::exists($path)) {
            return response()->json(['message' => 'Imagen no encontrada'], 404);
        }

        $file = Storage::get($path);
        $type = Storage::mimeType($path);

        return response($file, 200)->header('Content-Type', $type);
    }

    public function destroy(Request $request, $type, $filename)
    {
        if (!in_array($type, ['header', 'footer'])) {
            return response()->json(['message' => 'Tipo de imagen no válido'], 400);
        }

        $path = "public/images/{$type}/{$filename}";

        if (!Storage::exists($path)) {
            return response()->json(['message' => 'Imagen no encontrada'], 404);
        }

        if (Storage::delete($path)) {
            return response()->json(['message' => 'Imagen eliminada con éxito']);
        }

        return response()->json(['message' => 'No se pudo eliminar la imagen'], 500);
    }
}