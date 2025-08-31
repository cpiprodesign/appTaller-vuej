<?php
namespace App\Http\Controllers;

use App\Jobs\EliminarPdfTemporal;
use App\Models\Articulo;
use App\Models\ConfiguracionEmpresa;
use App\Models\DetalleVenta;
use App\Models\Documento;
use App\Models\Kardex;  // Asegúrate de importar el modelo Kardex
use App\Models\User;
use App\Models\Venta;
use App\Sunat\FacturaElectronicaService;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $ventas = Venta::with(['cliente', 'usuario', 'documento'])
                ->whereIn('estado', ['Registrado', 'Aceptado'])
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else {
            if (in_array($criterio, ['tipo_comprobante', 'serie_comprobante', 'num_comprobante'])) {
                // Filtro por campos de la tabla ventas
                $ventas = Venta::with(['cliente', 'usuario', 'documento'])
                    ->whereIn('estado', ['Registrado', 'Aceptado'])
                    ->where($criterio, 'like', '%' . $buscar . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(10);
            } elseif ($criterio === 'fecha_hora') {
                // Filtro por fecha exacta (solo fecha sin hora)
                $ventas = Venta::with(['cliente', 'usuario', 'documento'])
                    ->whereDate('fecha_hora', $buscar)
                    ->whereIn('estado', ['Registrado', 'Aceptado'])
                    ->orderBy('id', 'desc')
                    ->paginate(10);
            } else {
                // Filtro por relaciones: cliente o usuario
                $ventas = Venta::with(['cliente', 'usuario', 'documento'])
                    ->where(function ($query) use ($criterio, $buscar) {
                        if ($criterio === 'cliente') {
                            $query->whereHas('cliente', function ($q) use ($buscar) {
                                $q->where('nombre', 'like', '%' . $buscar . '%');
                            });
                        } elseif ($criterio === 'usuario') {
                            $query->whereHas('usuario', function ($q) use ($buscar) {
                                $q->where('usuario', 'like', '%' . $buscar . '%');
                            });
                        }
                    })
                    ->whereIn('estado', ['Registrado', 'Aceptado'])
                    ->orderBy('id', 'desc')
                    ->paginate(10);
            }
        }

        return [
            'pagination' => [
                'total' => $ventas->total(),
                'current_page' => $ventas->currentPage(),
                'per_page' => $ventas->perPage(),
                'last_page' => $ventas->lastPage(),
                'from' => $ventas->firstItem(),
                'to' => $ventas->lastItem(),
            ],
            'ventas' => $ventas,
        ];
    }

    public function obtenerCabecera(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $id = $request->id;
        $venta = Venta::join('clientes', 'ventas.idcliente', '=', 'clientes.id')
            ->join('users', 'ventas.idusuario', '=', 'users.id')
            ->select('ventas.id', 'ventas.tipo_comprobante', 'ventas.serie_comprobante',
                'ventas.num_comprobante', 'ventas.fecha_hora', 'ventas.impuesto', 'ventas.total',
                'ventas.estado', 'clientes.nombre', 'users.usuario')
            ->where('ventas.id', '=', $id)
            ->whereIn('estado', ['Registrado', 'Aceptado'])
            ->orderBy('ventas.id', 'desc')
            ->take(1)
            ->get();

        return ['venta' => $venta];
    }

    public function obtenerDetalles(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $id = $request->id;
        $detalles = DetalleVenta::join('articulos', 'detalle_ventas.idarticulo', '=', 'articulos.id')
            ->select('detalle_ventas.cantidad', 'detalle_ventas.precio', 'detalle_ventas.descuento',
                'articulos.nombre as articulo')
            // ->where('estado','=','Registrado')
            ->where('detalle_ventas.idventa', '=', $id)
            ->orderBy('detalle_ventas.id', 'desc')
            ->get();

        return ['detalles' => $detalles];
    }

    public function pdf(Request $request, $id)
    {
        $venta = Venta::join('clientes', 'ventas.idcliente', '=', 'clientes.id')
            ->join('users', 'ventas.idusuario', '=', 'users.id')
            ->select('ventas.id', 'ventas.fecha_hora', 'ventas.tipo_comprobante', 'ventas.serie_comprobante',
                'ventas.num_comprobante', 'ventas.created_at', 'ventas.impuesto', 'ventas.total',
                'ventas.estado', 'clientes.nombre', 'clientes.num_documento',
                'clientes.direccion', 'clientes.email', 'clientes.telefono', 'users.usuario')
            ->where('ventas.id', '=', $id)
            ->whereIn('estado', ['Registrado', 'Aceptado'])
            ->orderBy('ventas.id', 'desc')
            ->take(1)
            ->get();

        $detalles = DetalleVenta::join('articulo', 'detalle_ventas.idarticulo', '=', 'articulo.id')
            ->select('detalle_ventas.cantidad', 'detalle_ventas.precio', 'detalle_ventas.descuento',
                'articulo.nombre as articulo')
            ->where('detalle_ventas.idventa', '=', $id)
            ->orderBy('detalle_ventas.id', 'desc')
            ->get();

        $numventa = Venta::select('num_comprobante')->where('id', $id)->get();
        // configuracion
      //  $config = ConfiguracionEmpresa::first();  // Solo hay uno

        // Tu lógica de obtener venta y detalles aquí...
        // $qrContent = "hola mundo";
        $ventaData = $venta[0];  // o $venta->first()
        $igv = $ventaData->total * $ventaData->impuesto;
        $qrContent = '10458000889' . '|' . '03' . '|' . $ventaData->serie_comprobante . '|' . $ventaData->num_comprobante . '|' . $igv . '|' . $ventaData->total . '|' . $ventaData->fecha_hora . '|' . '1';

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrContent)
            ->size(200)
            ->margin(10)
            ->build();
        $qrBase64 = $result->getDataUri();  // Devuelve "data:image/png;base64,..."

        $pdf = \PDF::loadView('pdf.ventaTicket', ['venta' => $venta, 'detalles' => $detalles, 'qr' => $qrBase64 ]);
        // $pdf ->setPaper('a4','portrait');
        $pdf->setPaper([0, 0, 220.732, 841.89]);
        // $pdf->setPaper( array(0,0,612.00,1008.0));
        return $pdf->download('venta-' . $numventa[0]->num_comprobante . '.pdf');
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        try {
            DB::beginTransaction();
            $mytime = Carbon::now('America/Lima');

            $venta = new Venta();
            $venta->idcliente = $request->idcliente;
            $venta->idusuario = Auth::user()->id;
            $venta->id_documento = $request->id_documento;
            $venta->tipo_comprobante = $request->tipo_comprobante;
            $venta->serie_comprobante = $request->serie_comprobante;
            $venta->num_comprobante = $request->num_comprobante;
            $venta->fecha_hora = $mytime->toDateTimeString();
            $venta->impuesto = $request->impuesto;
            $venta->total = $request->total;
            $venta->estado = 'Registrado';
            $venta->save();

            $detalles = $request->data;

            foreach ($detalles as $det) {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->id;
                //$detalle->unidad = $det['Unidad'];
                $detalle->unidad="NIU";
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];
                $detalle->descuento = $det['descuento'];
                $detalle->save();

                // Descontar stock del artículo
                $articulo = Articulo::find($det['idarticulo']);
                 if ($articulo) {
                     $articulo->stock -= $det['cantidad'];
                     $articulo->save();
                 }

                // Registrar en el Kardex
                /*Kardex::create([
                    'id_articulo' => $det['idarticulo'],
                    'tipo_movimiento' => 'venta',
                    'documento' => $venta->tipo_comprobante . ' ' . $venta->serie_comprobante . '-' . $venta->num_comprobante,
                    'cantidad' => $det['cantidad'],
                    'precio_unitario' => $det['precio'],
                    'fecha' => now(),
                    'usuario_id' => Auth::id(),
                ]);*/
            }

            

            DB::commit();

            return response()->json([
                'success' => true,
                
                'id' => $venta->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $venta = Venta::findOrFail($request->id);
        $venta->estado = 'Anulado';
        $venta->save();
    }

    // consulta de  ventas

    public function ReporteVenta(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $fechaInicio = $request->fechaInicio . ' 00:00:00';
        $fechaFinal = $request->fechaFinal . ' 23:59:59';

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
                'ventas.total',
                'ventas.estado',
                'clientes.nombre',
                'users.usuario'
            )
            ->whereIn('estado', ['Registrado', 'Aceptado'])
            ->whereBetween('fecha_hora', [$fechaInicio, $fechaFinal])
            ->paginate(10);

        return [
            'pagination' => [
                'total' => $ventas->total(),
                'current_page' => $ventas->currentPage(),
                'per_page' => $ventas->perPage(),
                'last_page' => $ventas->lastPage(),
                'from' => $ventas->firstItem(),
                'to' => $ventas->lastItem(),
            ],
            'ventas' => $ventas,
        ];
    }

    // buscar el comprobante

    public function buscarComprobante(Request $request)
    {
       /* if (!$request->ajax()) {
            return redirect('/');
        }*/

        $filtro = $request->filtro;

        $venta = DB::table('ventas')
            // ->select(['id', 'tipo_comprobante', DB::raw('max(num_comprobante) AS numeroGenerado')])
            ->select(DB::raw('(max(num_comprobante)+1) as numero'))
            // ->leftJoin('users_ranks AS ur', 'ur.uid', '=', 'users.id')
            // ->select('id','tipo_comprobante','serie_comprobante','num_comprobante')
            ->where('tipo_comprobante', '=', $filtro)
            // ->groupBy('id')
            ->take(1)
            ->get();

        return ['ventas' => $venta];
    }

    public function pdfmodal(Request $request, $id)
    {
        // === DATOS DE LA VENTA ===
        $venta = Venta::join('clientes', 'ventas.idcliente', '=', 'clientes.id')
            ->join('users', 'ventas.idusuario', '=', 'users.id')
            ->select('ventas.id', 'ventas.fecha_hora', 'ventas.tipo_comprobante', 'ventas.serie_comprobante',
                'ventas.num_comprobante', 'ventas.created_at', 'ventas.impuesto', 'ventas.total',
                'ventas.estado', 'clientes.nombre', 'clientes.num_documento',
                'clientes.direccion', 'clientes.email', 'clientes.telefono', 'users.usuario')
            ->where('ventas.id', '=', $id)
            ->whereIn('estado', ['Registrado', 'Aceptado'])
            ->orderBy('ventas.id', 'desc')
            ->take(1)
            ->get();

        $detalles = DetalleVenta::join('articulo', 'detalle_ventas.idarticulo', '=', 'articulo.id')
            ->select('detalle_ventas.cantidad', 'detalle_ventas.precio', 'detalle_ventas.descuento',
                'articulo.nombre as articulo')
            ->where('detalle_ventas.idventa', '=', $id)
            ->orderBy('detalle_ventas.id', 'desc')
            ->get();

        //$config = ConfiguracionEmpresa::first();
        $ventaData = $venta[0];
        $igv = $ventaData->total * $ventaData->impuesto;

        // === CÓDIGO QR ===
        $qrContent = "10458000889|03|{$ventaData->serie_comprobante}|{$ventaData->num_comprobante}|{$igv}|{$ventaData->total}|{$ventaData->fecha_hora}";
        $qrResult = Builder::create()
            ->writer(new PngWriter())
            ->data($qrContent)
            ->size(200)
            ->margin(10)
            ->build();
        $qrBase64 = $qrResult->getDataUri();

        // === GENERAR PDF ===
        $pdf = \PDF::loadView('pdf.ventaTicket', [
            'venta' => $venta,
            'detalles' => $detalles,
            'qr' => $qrBase64
            //'config' => $config
        ]);
        $pdf->setPaper([0, 0, 220.732, 841.89]);

        // === GUARDAR EN public/comprobantes/ ===
        $fileName = 'venta_' . $ventaData->num_comprobante . '.pdf';
        $directPath = public_path('comprobantes');

        if (!File::exists($directPath)) {
            File::makeDirectory($directPath, 0755, true);
        }

        $fileFullPath = $directPath . '/' . $fileName;
        file_put_contents($fileFullPath, $pdf->output());

        if (!file_exists($fileFullPath)) {
            \Log::error("El archivo no se guardó correctamente en: $fileFullPath");
            return 'Error al guardar el PDF en disco';
        }

        // === URL pública del PDF
        $pdfUrl = url('comprobantes/' . $fileName);

        // Armar lista de productos
        $listaProductos = '';
        foreach ($detalles as $detalle) {
            $listaProductos .= "- {$detalle->articulo} x {$detalle->cantidad}\n";
        }

        // Armar el mensaje completo
        $mensaje = "🧾 *Comprobante de Venta*\n";
        $mensaje .= "Serie: {$ventaData->serie_comprobante}-{$ventaData->num_comprobante}\n";
        $mensaje .= "Total: S/ {$ventaData->total}\n";
        $mensaje .= "📦 Productos:\n{$listaProductos}";
        $mensaje .= "\nGracias por su compra. Aquí está su comprobante en PDF 📄";

        // === ENVIAR POR WHATSAPP
        try {
            // $telefono = $request->input('telefono');
            $telefono = $request->query('telefono');  // ?? $ventaData->telefono;
            $sid = config('services.twilio.sid');
            $token = config('services.twilio.token');
            $from = config('services.twilio.whatsapp_from');
            // $to = 'whatsapp:+51' . $ventaData->telefono;
            // $to = 'whatsapp:+51935667172';
            $to = 'whatsapp:+51' . $telefono;

            $twilio = new Client($sid, $token);
            $twilio->messages->create($to, [
                'from' => $from,
                'body' => $mensaje,
                // 'mediaUrl' => [$pdfUrl],
            ]);
        } catch (\Exception $e) {
            // \Log::error('Error al enviar WhatsApp: ' . $e->getMessage());
            // \Log::info('Twilio WhatsApp enviado:', (array) $response);
        }

        // === ELIMINAR ARCHIVO PDF DESPUÉS DE ENVIAR
        // if (File::exists($fileFullPath)) {
        //   File::delete($fileFullPath);
        // }

        // === MOSTRAR PDF EN NAVEGADOR
        return $pdf->stream($fileName);

        EliminarPdfTemporal::dispatch($fileFullPath)->delay(now()->addSeconds(60));
    }

    // para descargar xml
    public function descargarXml($nombre)
    {
        $path = storage_path("app/xml/{$nombre}");

        if (!file_exists($path)) {
            abort(404, 'Archivo XML no encontrado');
        }

        return response()->download($path, $nombre, [
            'Content-Type' => 'application/xml',
        ]);
    }

    // para descargar cdr
    public function descargarCdr($nombre)
    {
        $path = storage_path("app/cdr/{$nombre}");

        if (!file_exists($path)) {
            abort(404, 'Archivo ZIP no encontrado');
        }

        return response()->download($path, $nombre, [
            'Content-Type' => 'application/zip',
        ]);
    }
}
