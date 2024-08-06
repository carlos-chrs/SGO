<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class FuenteController
{
    public function index()
    {
        try {
            $fonts = Storage::files('fonts');
            return response()->json($fonts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'font' => 'required|file|max:2048',
            ]);

            $file = $request->file('font');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('fonts', $filename);

            return response()->json(['message' => 'Font uploaded successfully', 'path' => $path], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $filename)
    {
        try {
            $path = "fonts/$filename";
            if (!Storage::exists($path)) {
                return response()->json(['message' => 'Font not found'], 404);
            }

            Storage::delete($path);
            return response()->json(['message' => 'Font deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}