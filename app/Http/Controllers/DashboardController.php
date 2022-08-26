<?php

namespace App\Http\Controllers;
use App\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
       //grafico
       $anio=date('Y');//obtiene el año
       $totalServicioGrafico=DB::table('orden as o')
        ->select(DB::raw('MONTHNAME(o.fechaEntrada) as mes'),
        DB::raw('YEAR(o.fechaEntrada) as anio'),
        DB::raw('SUM(o.totalPagar) as total'))
        ->whereYear('o.fechaEntrada',$anio)
        ->groupBy(DB::raw('MONTHNAME(o.fechaEntrada)'),DB::raw('YEAR(o.fechaEntrada)'))
        ->get();

             //DISPOSITIVOS NO ENTREGADOS
             $totalDispositosNoEntregados = DB::table('orden')
            ->select('id')
            ->where('estado', '=','Reparacion finalizado')
            ->get();
            //dispostivos  en reparacion
            $totalDispositosEnReparacion = DB::table('orden')
            ->select('id')
            ->where('estado', '=','Reparando')
            ->get();
            //total servicio
            //ventas todo
            $totalServicio = DB::table('orden')
            ->select('id','totalPagar','adelanto')
            ->get();
            
      return ['dispositivosNoEntregados'=>$totalDispositosNoEntregados,
      'dispositivosEnReparacion'=>$totalDispositosEnReparacion,'totalServicio'=>$totalServicio,
      'totalServicioGrafico'=>$totalServicioGrafico] ;
    }
}