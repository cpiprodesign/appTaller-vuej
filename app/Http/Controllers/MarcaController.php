<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax())
            return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar == '') {
            $marcas = Marca::orderBy('id', 'desc')->paginate(6);  // elocuen
            // $categorias = Marca::where($criterio, 'like','%'. $buscar .'%')->orderBy('id','desc')->paginate(4);
        } else {
            $marcas = Marca::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        // $marcas =DB::table('marcas')->paginate(6);//generador de paginacio

        return [
            'pagination' => [
                'total' => $marcas->total(),
                'current_page' => $marcas->currentPage(),
                'per_page' => $marcas->perPage(),
                'last_page' => $marcas->lastPage(),
                'from' => $marcas->firstItem(),
                'to' => $marcas->lastItem(),
            ],
            'marcas' => $marcas
        ];
        // return $categorias;
    }

    // funcion para cargar categorias para mantenimiento de formulario articulo
    public function selectMarca(Request $request)
    {
        // if(!$request->ajax())return redirect('/');
        $marcas = Marca::where('condicion', '=', '1')
            ->select('id', 'nombre')
            ->orderBy('nombre', 'asc')
            ->get();
        return ['marcas' => $marcas];
    }

    public function store(Request $request)
    {
        if (!$request->ajax())
            return redirect('/');
        $marca = new Marca();
        $marca->nombre = $request->nombre;
        $marca->descripcion = $request->descripcion;
        $marca->condicion = '1';
        $marca->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax())
            return redirect('/');
        $marca = Marca::findOrFail($request->id);
        $marca->nombre = $request->nombre;
        $marca->descripcion = $request->descripcion;
        $marca->condicion = '1';
        $marca->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax())
            return redirect('/');
        $marca = Marca::findOrFail($request->id);
        $marca->condicion = '0';
        $marca->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax())
            return redirect('/');
        $marca = Marca::findOrFail($request->id);
        $marca->condicion = '1';
        $marca->save();
    }
}
