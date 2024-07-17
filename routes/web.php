<?php

use App\Livewire\FormularioPago;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/rol', function () {
        return view('view-formulario-rol');
    })->name('formulario.roles');

    Route::get('/cliente', function () {
        return view('view-formulario-cliente');
    })->name('formulario.clientes');

    Route::get('/proveedor', function () {
        return view('view-formulario-proveedor');
    })->name('formulario.proveedores');

    Route::get('/personal', function () {
        return view('view-formulario-personal');
    })->name('formulario.personal');

    Route::get('/categoria-insumo', function () {
        return view('view-formulario-categoria-insumo');
    })->name('formulario.categoria.insumos');

    Route::get('/insumo', function () {
        return view('view-formulario-insumo');
    })->name('formulario.insumos');

    Route::get('/movimiento', function () {
        return view('view-formulario-movimiento');
    })->name('formulario.movimientos');

    Route::get('/pedido', function () {
        return view('view-formulario-pedido');
    })->name('formulario.pedidos');

    Route::get('/cotizacion', function () {
        return view('view-formulario-cotizacion');
    })->name('formulario.cotizacions');


    Route::get('/reportes', function () {
        return view('view-formulario-reportes');
    })->name('formulario.reportes');



    //Armar pagoFacil
    /*

    use App\Http\Controllers\ConsumirServicioController;
    
    Route::post('/consumirServicio', [ConsumirServicioController::class, 'RecolectarDatos']);
    Route::post('/consultar', [ConsumirServicioController::class, 'ConsultarEstado']);
    */

});

//Callback
Route::post('/registrarPago', [App\Livewire\FormularioPago::class, 'urlCallback']);
//Route::get('/registrarPago', [App\Livewire\FormularioPago::class, 'urlCallback']);
