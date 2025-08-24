<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Exception;
use App\models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        // if(!$request->ajax())return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar == '') {
            $proveedores = Proveedor::orderBy('id', 'desc')->paginate(6);
        } else {
            $proveedores = Proveedor::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id', 'desc')->paginate(10);  // elocuen
        }
        // $personas =DB::table('categorias')->paginate(6);//generador de paginacio

        return [
            'pagination' => [
                'total' => $proveedores->total(),
                'current_page' => $proveedores->currentPage(),
                'per_page' => $proveedores->perPage(),
                'last_page' => $proveedores->lastPage(),
                'from' => $proveedores->firstItem(),
                'to' => $proveedores->lastItem(),
            ],
            'proveedores' => $proveedores
        ];
        // return $personas;
    }

    // funcion para cargar proveedor para mantenimiento de formulario articulo
    public function selectProveedor(Request $request)
    {
        if (!$request->ajax())
            return redirect('/');

        $proveedores = Proveedor::where('condicion', '=', '1')
            ->select('id', 'nombre')
            ->orderBy('nombre', 'asc')
            ->get();

        return ['proveedores' => $proveedores];
    }

    public function store(Request $request)
    {
        if (!$request->ajax())
            return redirect('/');
        $proveedor = new Proveedor();
        $proveedor->nombre = $request->nombre;
        $proveedor->tipo_documento = $request->tipo_documento;
        $proveedor->num_documento = $request->num_documento;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->condicion = '1';
        $proveedor->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax())
            return redirect('/');
        $proveedor = Proveedor::findOrFail($request->id);
        $proveedor->nombre = $request->nombre;
        $proveedor->tipo_documento = $request->tipo_documento;
        $proveedor->num_documento = $request->num_documento;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->condicion = '1';
        $proveedor->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax())
            return redirect('/');
        $proveedor = Proveedor::findOrFail($request->id);
        $proveedor->condicion = '0';
        $proveedor->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax())
            return redirect('/');
        $proveedor = Proveedor::findOrFail($request->id);
        $proveedor->condicion = '1';
        $proveedor->save();
    }
}
