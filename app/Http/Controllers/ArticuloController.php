<?php
namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        /* if (!$request->ajax()) {
             return redirect('/');
         }*/

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $articulo = Articulo::join('categoria', 'articulo.idcategoria', '=', 'categoria.id')
                ->join('marcas', 'articulo.idmarca', '=', 'marcas.id')
                // ->join('unidad', 'articulo.idunidad', '=', 'unidad.id')
                ->join('proveedor', 'articulo.idproveedor', '=', 'proveedor.id')
                ->select('articulo.id', 'articulo.idcategoria', 'articulo.idmarca', 'articulo.idproveedor', 'articulo.codigo', 'articulo.nombre', 'categoria.nombre as nombre_categoria', 'marcas.nombre as nombre_marca', 'proveedor.nombre as nombre proveedor', 'articulo.precio_venta', 'articulo.precio_compra', 'articulo.precio_base', 'articulo.stock', 'articulo.vencimiento', 'articulo.imagen', 'articulo.descripcion', 'articulo.condicion')
                ->orderBy('articulo.id', 'desc')
                ->paginate(10);
        } else {
            $articulo = Articulo::join('categoria', 'articulo.idcategoria', '=', 'categoria.id')
                ->join('marcas', 'articulo.idmarca', '=', 'marcas.id')
                // ->join('unidad', 'articulo.idunidad', '=', 'unidad.id')
                ->join('proveedor', 'articulo.idproveedor', '=', 'proveedor.id')
                ->select('articulo.id', 'articulo.idcategoria', 'articulo.idmarca', 'articulo.idproveedor', 'articulo.codigo', 'articulo.nombre', 'categoria.nombre as nombre_categoria', 'marcas.nombre as nombre_marca', 'proveedor.nombre as nombreproveedor', 'articulo.precio_venta', 'articulo.precio_compra', 'articulo.precio_base', 'articulo.stock', 'articulo.vencimiento', 'articulo.imagen', 'articulo.descripcion', 'articulo.condicion')
                ->where('articulo.' . $criterio, 'like', '%' . $buscar . '%')
                ->orderBy('articulo.id', 'desc')
                ->paginate(20);
        }

        return [
            'pagination' => [
                'total' => $articulo->total(),
                'current_page' => $articulo->currentPage(),
                'per_page' => $articulo->perPage(),
                'last_page' => $articulo->lastPage(),
                'from' => $articulo->firstItem(),
                'to' => $articulo->lastItem(),
            ],
            'articulo' => $articulo,
        ];
    }

    public function listarArticulo(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $articulo = Articulo::join('categoria', 'articulo.idcategoria', '=', 'categoria.id')
                ->join('marcas', 'articulo.idmarca', '=', 'marcas.id')
                //  ->join('unidad', 'articulo.idunidad', '=', 'unidad.id')
                ->join('proveedor', 'articulo.idproveedor', '=', 'proveedor.id')
                ->select('articulo.id', 'articulo.idcategoria', 'articulo.idmarca', 'articulo.idproveedor', 'articulo.codigo', 'articulo.nombre', 'categoria.nombre as nombre_categoria', 'marcas.nombre as nombre_marca', 'proveedor.nombre as nombre_proveedor', 'articulo.precio_venta', 'articulo.precio_compra', 'articulo.stock', 'articulo.vencimiento', 'articulo.imagen', 'articulo.descripcion', 'articulo.condicion')
                ->orderBy('articulo.id', 'desc')
                ->paginate(10);
        } else {
            $articulo = Articulo::join('categoria', 'articulo.idcategoria', '=', 'categoria.id')
                ->join('marcas', 'articulo.idmarca', '=', 'marcas.id')
                // ->join('unidad', 'articulo.idunidad', '=', 'unidad.id')
                ->join('proveedor', 'articulo.idproveedor', '=', 'proveedor.id')
                ->select('articulo.id', 'articulo.idcategoria', 'articulo.idmarca', 'articulo.idproveedor', 'articulo.codigo', 'articulo.nombre', 'categoria.nombre as nombre_categoria', 'marcas.nombre as nombre_marca', 'unidad.nombre as nombre_unidad', 'proveedor.nombre as nombre_proveedor', 'articulo.precio_venta', 'articulo.precio_compra', 'articulo.stock', 'articulo.vencimiento', 'articulo.imagen', 'articulo.descripcion', 'articulo.condicion')
                ->where('articulo.' . $criterio, 'like', '%' . $buscar . '%')
                ->orderBy('articulo.id', 'desc')
                ->paginate(10);
        }

        return ['articulo' => $articulo];
    }

    public function listarArticuloVenta(Request $request)
    {
        /* if (! $request->ajax()) {
            return redirect('/');
        }*/

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $articulo = Articulo::join('categoria', 'articulo.idcategoria', '=', 'categoria.id')
                ->join('marcas', 'articulo.idmarca', '=', 'marcas.id')
                // ->join('unidad', 'articulo.idunidad', '=', 'unidad.id')
                ->join('proveedor', 'articulo.idproveedor', '=', 'proveedor.id')
                ->select('articulo.id', 'articulo.idcategoria', 'articulo.idmarca', 'articulo.idproveedor', 'articulo.codigo', 'articulo.nombre', 'categoria.nombre as nombre_categoria', 'marcas.nombre as nombre_marca', 'proveedor.nombre as nombre_proveedor', 'articulo.precio_venta', 'articulo.precio_compra', 'articulo.precio_base', 'articulo.stock', 'articulo.vencimiento', 'articulo.imagen', 'articulo.descripcion', 'articulo.condicion')
                ->where('articulo.stock', '>', '0')
                ->orderBy('articulo.id', 'desc')
                ->paginate(10);
        } else {
            $articulo = Articulo::join('categoria', 'articulo.idcategoria', '=', 'categoria.id')
                ->join('marcas', 'articulo.idmarca', '=', 'marcas.id')
                // ->join('unidad', 'articulo.idunidad', '=', 'unidad.id')
                ->join('proveedor', 'articulo.idproveedor', '=', 'proveedor.id')
                ->select('articulo.id', 'articulo.idcategoria', 'articulo.idmarca', 'articulo.idproveedor', 'articulo.codigo', 'articulo.nombre', 'categoria.nombre as nombre_categoria', 'marcas.nombre as nombre_marca', 'proveedor.nombre as nombre_proveedor', 'articulo.precio_venta', 'articulo.precio_compra', 'precio_base', 'articulo.stock', 'articulo.vencimiento', 'articulo.imagen', 'articulo.descripcion', 'articulo.condicion')
                ->where('articulo.' . $criterio, 'like', '%' . $buscar . '%')
                ->where('articulo.stock', '>', '0')
                ->orderBy('articulo.id', 'desc')
                ->paginate(10);
        }

        return ['articulo' => $articulo];
    }

    public function listarPdf()
    {
        $articulo = Articulo::join('categoria', 'articulo.idcategoria', '=', 'categoria.id')
            ->join('marcas', 'articulo.idmarca', '=', 'marcas.id')
            // ->join('unidad', 'articulo.idunidad', '=', 'unidad.id')
            ->join('proveedor', 'articulo.idproveedor', '=', 'proveedor.id')
            ->select('articulo.id', 'articulo.idcategoria', 'articulo.idmarca', 'articulo.idproveedor', 'articulo.codigo', 'articulo.nombre', 'categoria.nombre as nombre_categoria', 'marcas.nombre as nombre_marca', 'proveedor.nombre as nombre_proveedor', 'articulo.precio_venta', 'articulo.precio_compra', 'articulo.stock', 'articulo.vencimiento', 'articulo.imagen', 'articulo.descripcion', 'articulo.condicion')
            ->orderBy('articulo.id', 'desc')
            ->get();

        $cont = Articulo::count();

        $pdf = \PDF::loadView('pdf.articulopdf', ['articulo' => $articulo, 'cont' => $cont]);
        return $pdf->download('articulo.pdf');
    }

    public function buscarArticulo(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $filtro = $request->filtro;
        $articulo = Articulos::where('codigo', '=', $filtro)
            ->select('id', 'nombre', 'precio_compra', 'precio_venta')
            ->orderBy('nombre', 'asc')
            ->take(1)
            ->get();

        return ['articulo' => $articulo];
    }

    public function buscarArticuloVenta(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $filtro = $request->filtro;
        $articulo = Articulos::where('codigo', '=', $filtro)
            ->select('id', 'nombre', 'stock', 'precio_venta')
            ->where('stock', '>', '0')
            ->orderBy('nombre', 'asc')
            ->take(1)
            ->get();

        return ['articulo' => $articulo];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $articulo = new Articulo();
        $articulo->idcategoria = $request->idcategoria;
        $articulo->idmarca = $request->idmarca;
        // $articulo->idUnidad = $request->idunidad;
        $articulo->idproveedor = $request->idproveedor;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->precio_compra = $request->precio_compra;
        $articulo->precio_base = $request->precio_base;
        $articulo->stock = $request->stock;
        $articulo->vencimiento = $request->vencimiento;
        $articulo->imagen = 'no tiene ';
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->idmarca = $request->idmarca;
        // $articulo->idUnidad = $request->idunidad;
        $articulo->idproveedor = $request->idproveedor;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->precio_compra = $request->precio_compra;
        $articulo->precio_base = $request->precio_base;
        $articulo->stock = $request->stock;
        $articulo->vencimiento = $request->vencimiento;
        $articulo->imagen = 'no tiene';
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '0';
        $articulo->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '1';
        $articulo->save();
    }

    //
    public function importExcel(Request $request)
    {
        $file = $request->file('excel');

        // Validar el archivo
        $request->validate([
            'excel' => 'required|mimes:xlsx,xls',
        ]);

        // Importar datos
        (new FastExcel)->import($file, function ($line) {
            Articulos::create([
                'id' => $line['id'],
                'idcategoria' => $line['idcategoria'],
                'idmarca' => $line['idmarca'],
                // 'idUnidad' => $line['idunidad'],
                'idproveedor' => $line['idproveedor'],
                'codigo' => $line['codigo'],
                'nombre' => $line['nombre'],
                'precio_venta' => $line['precioventa'],
                'precio_compra' => $line['preciocompra'],
                'stock' => $line['stock'],
                'vencimiento' => $line['vencimiento'],
                'imagen' => $line['imagen'],
                'descripcion' => $line['descripcion'],
                // Mapea las columnas del archivo de Excel con las columnas de tu modelo
            ]);
        });

        return response()->json(['message' => 'Importación exitosa de Articulos']);
    }
}
