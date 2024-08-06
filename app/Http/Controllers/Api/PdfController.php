<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request; 
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PdfController

{
    function crearPdf(Request $request){

  

    // Validar los datos de entrada
    // $validatedData = $request->validate([
    //     'title' => 'required|string',
    //     'content' => 'required|string',
    // ]);
    try {
        $data = [
            'title' => 'Mi PDF generado',
            'content' => 'Este es el contenido del PDF'
        ];
        
        $pdf = PDF::loadView('pdf.documento', $data);
        
        return $pdf->download('mi_documento.pdf');
    } catch (\Exception $e) {
        Log::error('Error generando PDF: ' . $e->getMessage());
        return response()->json(['error' => 'No se pudo generar el PDF'], 500);
    }
    }


}
