<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\Cliente;
use App\Models\Tecnico;
class OrdenController extends Controller
{
    public function index(Request $request)
    {
       if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $ordenes = Orden::join('clientes', 'orden.idcliente', '=', 'clientes.id')
                ->join('tecnicos', 'orden.idtecnico', '=', 'tecnicos.id')
                ->select(
                    'orden.id',
                    'clientes.id as idcliente', 
                    'tecnicos.id as idtecnico',
                    'clientes.nombre as Cliente',                    
                    'tecnicos.nombre as Tecnico',
                    'orden.nombreEquipo',
                    'orden.marca',
                    'orden.modelo',
                    'orden.serial',
                    'orden.clave',
                    'orden.accesorios',
                    'orden.observaciones',
                    'orden.fallaEquipo',
                    'orden.reparacion',
                    'orden.fechaEntrada',
                    'orden.fechaEntrega',
                    'orden.adelanto',
                    'orden.totalPagar',
                    'orden.estado'
                )
                ->orderBy('orden.id', 'desc')
                ->paginate(6);
        } else {
            $ordenes = Orden::join('clientes', 'orden.idcliente', '=', 'clientes.id')
                ->join('tecnicos', 'orden.idtecnico', '=', 'tecnicos.id')
                ->select(
                    'orden.id',
                    'clientes.nombre as Cliente',                    
                    'tecnicos.nombre as Tecnico',
                    'orden.nombreEquipo',
                    'orden.marca',
                    'orden.modelo',
                    'orden.serial',
                    'orden.clave',
                    'orden.accesorios',
                    'orden.observaciones',
                    'orden.fallaEquipo',
                    'orden.reparacion',
                    'orden.fechaEntrada',
                    'orden.fechaEntrega',
                    'orden.adelanto',
                    'orden.totalPagar',
                    'orden.estado'
                )
                ->where('orden.' . $criterio, 'like', '%' . $buscar . '%')
                ->orderBy('orden.id', 'desc')->paginate(6);
        }

        return [
            'pagination' => [
                'total'        => $ordenes->total(),
                'current_page' => $ordenes->currentPage(),
                'per_page'     => $ordenes->perPage(),
                'last_page'    => $ordenes->lastPage(),
                'from'         => $ordenes->firstItem(),
                'to'           => $ordenes->lastItem(),
            ],
            'ordenes' => $ordenes
        ];
    }
    public function obtenerCabecera(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $venta = orden::join('clientes', 'orden.idcliente', '=', 'clientes.id')
            ->join('tecnicos', 'orden.idtecnico', '=', 'tecnicos.id')
            ->select(
                'orden.id',
                    'clientes.nombre',                    
                    'tecnicos.nombre',
                    'orden.nombre',
                    'orden.marca',
                    'orden.modelo',
                    'orden.serial',
                    'orden.clave',
                    'orden.accesorios',
                    'orden.observaciones',
                    'orden.fallaEquipo',
                    'orden.reparacion',
                    'orden.fechaEntrada',
                    'orden.fechaEntrega',
                    'orden.adelanto',
                    'orden.totalPagar',
                    'orden.estado'
            )
            ->where('orden.id', '=', $id)
            ->orderBy('orden.id', 'desc')->take(1)->get();

        return ['venta' => $venta];
    }
    public function obtenerDetalles(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleVenta::join('productos', 'detalle_ventas.idproducto', '=', 'productos.id')
            ->select('detalle_ventas.cantidad', 'detalle_ventas.precio', 'productos.nombre as articulo', 'detalle_ventas.descuento')
            ->where('detalle_ventas.idventa', '=', $id)
            ->orderBy('detalle_ventas.id', 'desc')->get();

        return ['detalles' => $detalles];
    }
    public function pdf(Request $request,$id){
        $ordenes = Orden::join('clientes', 'orden.idcliente', '=', 'clientes.id')
        ->join('tecnicos', 'orden.idtecnico', '=', 'tecnicos.id')
        ->select('orden.id',
        'clientes.id as idcliente',
        'clientes.nombre as nombreCliente', 
        'tecnicos.id as idtecnico',
        'clientes.nombre as Cliente',                    
        'tecnicos.nombre as Tecnico',
        'orden.nombreEquipo',
        'orden.marca',
        'orden.modelo',
        'orden.serial',
        'orden.clave',
        'orden.accesorios',
        'orden.observaciones',
        'orden.fallaEquipo',
        'orden.reparacion',
        'orden.fechaEntrada',
        'orden.fechaEntrega',
        'orden.adelanto',
        'orden.totalPagar',
        'orden.estado')
        ->where('orden.id','=',$id)
        ->orderBy('orden.id','desc')->take(1)->get();

       /* $detalles = DetalleVenta::join('productos','detalle_ventas.idproducto','=','productos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','detalle_ventas.descuento',
        'productos.nombre as articulo')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id','desc')->get();*/

        $numOrden=Orden::select('id')->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.ordenTicket',['ordenes'=>$ordenes]);
       //$pdf ->setPaper('a4','portrait');
       $pdf->setPaper( [0, 0, 220.732,  841.89]); 
      // $pdf->setPaper( array(0,0,612.00,1008.0)); 
      return $pdf->download('orden-'.$numOrden[0]->id.'.pdf');
        //return $pdf->download('venta-'.$numventa[0]->num_comprobante.'.pdf');
       
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        
            //$fechaEntrada = Carbon::now('America/Lima');

            $orden = new Orden();
            $orden->idcliente = $request->idcliente;
            //$orden->idtecnico = Auth::user()->id;
            $orden->idtecnico = $request->idtecnico;
            $orden->nombreEquipo = $request->nombreEquipo;
            $orden->marca = $request->marca;
            $orden->modelo = $request->modelo;
            //$orden->serial = $mytime->toDateString();
            $orden->serial = $request->serial;
            $orden->clave = $request->clave;
            $orden->accesorios = $request->accesorios;
            $orden->observaciones = $request->observaciones;
            $orden->fallaEquipo = $request->fallaEquipo;
            $orden->reparacion = $request->reparacion;
            //$orden->fechaEntrada = $fechaEntrada->toDateString();
            $orden->fechaEntrada =$request->fechaEntrada;
            $orden->fechaEntrega = $request->fechaEntrega;
            $orden->adelanto = $request->adelanto;
            $orden->totalPagar = $request->totalPagar;
            $orden->estado =$request->estado;
            $orden->save();

          
    }
    public function update(Request $request)
    { 
        if (!$request->ajax()) return redirect('/');
        $orden = Orden::findOrFail($request->id);
        $orden->idcliente = $request->idcliente;
        //$orden->idtecnico = Auth::user()->id;
        $orden->idtecnico = $request->idtecnico;
        $orden->nombreEquipo = $request->nombreEquipo;
        $orden->marca = $request->marca;
        $orden->modelo = $request->modelo;
        //$orden->serial = $mytime->toDateString();
        $orden->serial = $request->serial;
        $orden->clave = $request->clave;
        $orden->accesorios = $request->accesorios;
        $orden->observaciones = $request->observaciones;
        $orden->fallaEquipo = $request->fallaEquipo;
        $orden->reparacion = $request->reparacion;
        //$orden->fechaEntrada = $fechaEntrada->toDateString();
        $orden->fechaEntrada =$request->fechaEntrada;
        $orden->fechaEntrega = $request->fechaEntrega;
        $orden->adelanto = $request->adelanto;
        $orden->totalPagar = $request->totalPagar;
        $orden->estado =$request->estado;
        $orden->save();
        //dd($orden);
        
        
    }
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ordenes = orden::findOrFail($request->id);
        $ordenes->estado = 'Anulado';
        $ordenes->save();
    }
//buscar el comprobante

    public function buscarComprobante(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
       // $venta = Ventas::where('tipo_comprobante','=', $filtro)
      // $venta = Ventas::where('tipo_comprobante','=', $filtro)
       // ->select('id','tipo_comprobante','serie_comprobante','num_comprobante')
       //->max('num_comprobante')
        //->orderBy('nombre', 'asc')
        //->take(1)->get();
      //  ->first() ;
        //->get() ;
       //--------
       $venta= DB::table('ventas')
      // ->select(['id', 'tipo_comprobante', DB::raw('max(num_comprobante) AS numeroGenerado')])
       ->select( DB::raw('(max(num_comprobante)+1) as numero'))
       //->leftJoin('users_ranks AS ur', 'ur.uid', '=', 'users.id')
        //->select('id','tipo_comprobante','serie_comprobante','num_comprobante')
       ->where('tipo_comprobante', '=', $filtro)
      //->groupBy('id')
      ->take(1)->get();
      

        return ['ventas' => $venta];

    }
    //consulta de  ventas

    public function ReporteVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $fechaInicio = $request->fechaInicio;
        $fechaFinal = $request->fechaFinal;
        $ventas = DB::table('ventas')
        ->join('clientes', 'ventas.idcliente', '=', 'clientes.id')
        ->join('users', 'ventas.idusuario', '=', 'users.id')
        ->select(
            'ventas.id',
            'ventas.tipo_comprobante',
            'ventas.serie_comprobante',
            'ventas.num_comprobante',
            'ventas.fecha_hora',
            'ventas.impuesto',
            'ventas.subTotal',
            'ventas.Igv',
            'ventas.total',
            'ventas.estado',
            'clientes.nombre',
            'users.usuario'
        )
        ->whereBetween('fecha_hora', [$fechaInicio, $fechaFinal])
        ->paginate(10);

        return [
            'pagination' => [
                'total'        => $ventas->total(),
                'current_page' => $ventas->currentPage(),
                'per_page'     => $ventas->perPage(),
                'last_page'    => $ventas->lastPage(),
                'from'         => $ventas->firstItem(),
                'to'           => $ventas->lastItem(),
            ],
            
            'ventas' => $ventas
        ];
    }
}
