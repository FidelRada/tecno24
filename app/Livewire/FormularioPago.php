<?php

namespace App\Livewire;

use App\Models\Pago;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormularioPago extends Component
{
    public function urlCallback(Request $request)
    {   
        
        Log::info('Entrando en el método urlCallback ahora desde ngrok');
        Log::info($request);

        $Venta = $request->input("PedidoID");
        $Fecha = $request->input("Fecha");
        $NuevaFecha = date("Y-m-d", strtotime($Fecha));
        $Hora = $request->input("Hora");
        $MetodoPago = $request->input("MetodoPago");
        $Estado = $request->input("Estado");
        $Ingreso = true;
        
        $cadena = $Venta;
        preg_match('/\*(\d+)/', $cadena, $matches);
        //preg_match('/-(\d+)$/', $cadena, $matches);
        if (!empty($matches[1])) {
            // Convertimos el valor encontrado a entero y lo devolvemos
            $resultado = (int) $matches[1];
        } 
        //dd($resultado);

        $pedidoDetail = Pedido::find($resultado);
        //dd($pedidoDetail);

        $pagoCreated = Pago::create([
            'pedido_id' => $resultado, 
            'fechapago' => $NuevaFecha, 
            'horapago' => $Hora, 
            'estado' => $Estado, 
            'metodopago' => $MetodoPago,
        ]);

        $pedidoDetail->update([            
            'estado' => "Pagado",                 
        ]);

        try {
          //  propceso de verificacion y procesando el pago ya en el lado del comercio
            $arreglo = ['error' => 0, 'status' => 1, 'message' => "Pago realizado correctamente.", 'values' => true];
        } catch (\Throwable $th) {
            $arreglo = ['error' => 1, 'status' => 1, 'messageSistema' => "[TRY/CATCH] " . $th->getMessage(), 'message' => "No se pudo realizar el pago, por favor intente de nuevo.", 'values' => false];
        }

        return response()->json($arreglo);
    }    

    public function render()
    {
        //return view('livewire.formulario-pago');
    }
}
