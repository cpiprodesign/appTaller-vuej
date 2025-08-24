<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */
Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
    Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
    // Route::get('/login',[App\Http\Controllers\Auth\LoginController::class,'showLoginForm'])->name('login');
    // Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

    // Route::get('/ordenestado/{id}', [App\Http\Controllers\OrdenController::class,'consultaEstadoEquipo']);

    Route::get('/Query/', [App\Http\Controllers\ConsultaController::class, 'consultaEstadoEquipo']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/main', function () {  // aqui cambie de main a nada
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware' => ['Tecnico']], function () {
        // clientes
        Route::get('cliente', [App\Http\Controllers\ClienteController::class, 'index'])->name('cliente');
        Route::post('/cliente/registrar', [App\Http\Controllers\ClienteController::class, 'store']);
        Route::put('/cliente/actualizar', [App\Http\Controllers\ClienteController::class, 'update']);
        Route::put('/cliente/desactivar', [App\Http\Controllers\ClienteController::class, 'desactivar']);
        Route::put('/cliente/activar', [App\Http\Controllers\ClienteController::class, 'activar']);
        Route::get('/cliente/selectCliente', [App\Http\Controllers\ClienteController::class, 'selectCliente']);
        Route::get('/cliente/listarPdf', [App\Http\Controllers\ClienteController::class, 'listarPdf'])->name('clientes_pdf');

        // orden
        Route::get('orden', [App\Http\Controllers\OrdenController::class, 'index'])->name('orden');
        Route::get('ordentecnico', [App\Http\Controllers\OrdenController::class, 'indextecnico'])->name('ordentecnico');
        Route::post('/orden/registrar', [App\Http\Controllers\OrdenController::class, 'store']);
        Route::put('/orden/actualizar', [App\Http\Controllers\OrdenController::class, 'update']);
        // Route::get('/orden/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');//para reportes de comprobante
        Route::get('/orden/pdf/{id}', [App\Http\Controllers\OrdenController::class, 'pdf'])->name('orden_pdf');  // para reportes de comprobante
        // repote rango de fechas
        Route::get('/orden/reportes', [App\Http\Controllers\OrdenController::class, 'ReporteOrden']);
        // practicando
        Route::get('/orden1/pdf/{id}', [App\Http\Controllers\OrdenController::class, 'generatePDF']);

        // dashboard
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, '__invoke']);
    });

    // ----ruta administrador
    Route::group(['middleware' => ['Administrador']], function () {
        // clientes
        Route::get('cliente', [App\Http\Controllers\ClienteController::class, 'index'])->name('cliente');
        Route::post('/cliente/registrar', [App\Http\Controllers\ClienteController::class, 'store']);
        Route::put('/cliente/actualizar', [App\Http\Controllers\ClienteController::class, 'update']);
        Route::put('/cliente/desactivar', [App\Http\Controllers\ClienteController::class, 'desactivar']);
        Route::put('/cliente/activar', [App\Http\Controllers\ClienteController::class, 'activar']);
        Route::get('/cliente/selectCliente', [App\Http\Controllers\ClienteController::class, 'selectCliente']);
        Route::get('/cliente/listarPdf', [App\Http\Controllers\ClienteController::class, 'listarPdf'])->name('clientes_pdf');

        // tecnicos

        Route::get('tecnico', [App\Http\Controllers\TecnicoController::class, 'index'])->name('tecnico');
        Route::post('/tecnico/registrar', [App\Http\Controllers\TecnicoController::class, 'store']);
        Route::put('/tecnico/actualizar', [App\Http\Controllers\TecnicoController::class, 'update']);
        Route::put('/tecnico/desactivar', [App\Http\Controllers\TecnicoController::class, 'desactivar']);
        Route::put('/tecnico/activar', [App\Http\Controllers\TecnicoController::class, 'activar']);
        Route::get('/tecnico/selectTecnico', [App\Http\Controllers\TecnicoController::class, 'selectTecnico']);
        Route::get('/tecnico/listarPdf', [App\Http\Controllers\TecnicoController::class, 'listarPdf'])->name('tecnicos_pdf');

        // orden
        Route::get('orden', [App\Http\Controllers\OrdenController::class, 'index'])->name('orden');
        Route::post('/orden/registrar', [App\Http\Controllers\OrdenController::class, 'store']);
        Route::put('/orden/actualizar', [App\Http\Controllers\OrdenController::class, 'update']);
        // Route::get('/orden/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');//para reportes de comprobante
        Route::get('/orden/pdf/{id}', [App\Http\Controllers\OrdenController::class, 'pdf'])->name('orden_pdf');  // para reportes de comprobante
        // repote rango de fechas
        Route::get('/orden/reportes', [App\Http\Controllers\OrdenController::class, 'ReporteOrden']);
        // practicando
        Route::get('/orden1/pdf/{id}', [App\Http\Controllers\OrdenController::class, 'generatePDF']);

        // dashboard
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, '__invoke']);
        // logout
        // Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');

        Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    });

    // users
    Route::get('/user', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('/user/selectuser', [App\Http\Controllers\UserController::class, 'selectUser']);
    // Route::get('user', [UserController::class, 'index'])->name('user');
    Route::post('/user/registrar', [App\Http\Controllers\UserController::class, 'store']);
    Route::put('/user/actualizar', [App\Http\Controllers\UserController::class, 'update']);
    Route::put('/user/desactivar', [App\Http\Controllers\UserController::class, 'desactivar']);
    Route::put('/user/activar', [App\Http\Controllers\UserController::class, 'activar']);

    // Roles
    Route::get('/rol', [App\Http\Controllers\RolController::class, 'index'])->name('roles');
    Route::get('rol/selectRol', [App\Http\Controllers\RolController::class, 'selectRol']);

    // imagenorden
    Route::post('/api/upload-image', [App\Http\Controllers\ImageController::class, 'store']);
    // genera codigo qr
    Route::get('api/barcode/{text}', [App\Http\Controllers\BarcodeController::class, 'generate']);
    // envio de mensaje a whatsapp
    Route::get('msg', [App\Http\Controllers\MensajeController::class, 'msg']);

    // categoria
    Route::get('categoria', [CategoriaController::class, 'index'])->name('categoria');
    Route::get('categoria/listar', [CategoriaController::class, 'selectCategoria']);
    Route::post('/categoria/registrar', [CategoriaController::class, 'store']);
    Route::put('/categoria/actualizar', [CategoriaController::class, 'update']);
    Route::put('/categoria/desactivar', [CategoriaController::class, 'desactivar']);
    Route::put('/categoria/activar', [CategoriaController::class, 'activar']);
    Route::post('/categoria/importar', [CategoriaController::class, 'importExcel']);  // para importar data

    // marca
    Route::get('marca', [marcaController::class, 'index'])->name('marca');
    Route::get('marca/listar', [marcaController::class, 'selectMarca']);
    Route::post('/marca/registrar', [marcaController::class, 'store']);
    Route::put('/marca/actualizar', [marcaController::class, 'update']);
    Route::put('/marca/desactivar', [marcaController::class, 'desactivar']);
    Route::put('/marca/activar', [marcaController::class, 'activar']);

    // proveedor
    Route::get('/proveedor', [ProveedorController::class, 'index']);
    Route::post('/proveedor/registrar', [ProveedorController::class, 'store']);
    Route::put('/proveedor/actualizar', [ProveedorController::class, 'update']);
    Route::put('/proveedor/desactivar', [ProveedorController::class, 'desactivar']);
    Route::put('/proveedor/activar', [ProveedorController::class, 'activar']);
    Route::get('/proveedor/listar', [ProveedorController::class, 'selectProveedor']);

    // articulos
    Route::get('articulo', [ArticuloController::class, 'index'])->name('articulo');
    Route::post('/articulo/registrar', [ArticuloController::class, 'store']);
    Route::put('/articulo/actualizar', [ArticuloController::class, 'update']);
    Route::put('/articulo/desactivar', [ArticuloController::class, 'desactivar']);
    Route::put('/articulo/activar', [ArticuloController::class, 'activar']);
    Route::get('/articulo/listarArticulo', [ArticuloController::class, 'listarArticulo']);
    Route::get('/articulo/listarArticuloVenta', [ArticuloController::class, 'listarArticuloVenta']);
    Route::get('/articulo/buscarArticulo', [ArticuloController::class, 'buscarArticulo']);
    Route::get('/articulo/buscarArticuloVenta', [ArticuloController::class, 'buscarArticuloVenta']);
    Route::get('/articulo/listarPdf', [ArticuloController::class, 'listarPdf'])->name('articulos_pdf');
    Route::post('/articulo/importar', [ArticuloController::class, 'importExcel']);  // para importar data

    // venta

    Route::get('/venta', [VentaController::class, 'index'])->name('venta');
    Route::post('/venta/registrar', [VentaController::class, 'store']);
    Route::put('/venta/desactivar', [VentaController::class, 'desactivar']);
    Route::get('/venta/obtenerCabecera', [VentaController::class, 'obtenerCabecera']);
    Route::get('/venta/obtenerDetalles', [VentaController::class, 'obtenerDetalles']);
    Route::get('/venta/buscarComprobanteVenta', [VentaController::class, 'buscarComprobante']);
    // reporte de ventas por fecha
    Route::get('/venta/reportes', [VentaController::class, 'reporteVenta']);
    Route::get('/venta/pdfimprimir/{id}', [App\Http\Controllers\VentaController::class, 'pdfmodal'])->name('orden_pdf');  // para imprim
    Route::get('/venta/pdf/{id}', [VentaController::class, 'pdf'])->name('venta_pdf');  // para reportes de comprobante
    // descarga xml
    Route::get('/descargar-xml/{nombre}', [App\Http\Controllers\VentaController::class, 'descargarXml']);
    // Para CDR (ZIP)
    Route::get('/descargar-cdr/{nombre}', [App\Http\Controllers\VentaController::class, 'descargarCdr']);
});

// Auth::routes();

// Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');
