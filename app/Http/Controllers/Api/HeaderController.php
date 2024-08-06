<?php

namespace App\Http\Controllers\Api;

use App\Models\header;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeaderController
{
   
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/header', $name);
            
            return response()->json(['message' => 'imagen subida exitosamente', 'path' => $path]);
        }

        return response()->json(['message' => 'No image file uploaded'], 400);
    }

    public function index()
    {
        $images = Storage::files('public/images');
        return response()->json($images);
    }

    public function show($id)
    {
        $path = 'public/images/' . $id;
        if (Storage::exists($path)) {
            return response()->file(storage_path('app/' . $path));
        }
        return response()->json(['message' => 'Image not found'], 404);
    }

    public function destroy($id)
    {
        $path = 'public/images/' . $id;
        if (Storage::exists($path)) {
            Storage::delete($path);
            return response()->json(['message' => 'Image deleted successfully']);
        }
        return response()->json(['message' => 'Image not found'], 404);
    }
}
