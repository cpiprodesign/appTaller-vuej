<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Tipo_documento_controller extends Controller
{
     //funcion para cargar tipo de documentos para mantenimiento de formulario clientes
    public function selectDocumentos(Request $request)
    {
        //if (! $request->ajax()) {
        //   return redirect('/');
        //}

        $documentos = tipo_documento_identidad::where('activo', '=', '1')
            ->select('id', 'descripcion')
            ->orderBy('descripcion', 'asc')
            ->get();
        return ['documentos' => $documentos];

    }
}
