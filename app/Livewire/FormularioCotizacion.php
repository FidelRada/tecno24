<?php

namespace App\Livewire;

use App\Models\Cotizacion;
use App\Models\DetallePedido;
use App\Models\Paginacion;
use App\Models\Pedido;
use App\Models\Servicio;
use Livewire\Component;

class FormularioCotizacion extends Component
{

    public $cotizacions;
    public $postEditId = '';

    public $pedidoDetail = [];
    public $resultadoDetail = [];
    public $clienteDetail = [];
    public $personaDetail = [];

    public $openModalDetalleVerPedidoCotizacion = false;
    public $mostrarModalEnviarCotizacion = false;

    public $postModalCotizacion = [                
        'descripcioncotizacion' => '',          
        'costo' => '',
        'url' => '',                  
    ];

    public function messages()
    {
        return [            
            'postModalCotizacion.descripcioncotizacion.required' => 'El Campo Descripcion es requerido',
            'postModalCotizacion.costo.required' => 'El Campo Costo es requerido', 
            'postModalCotizacion.url.required' => 'El Campo URL es requerido', 
        ];
    }

    public function verPedidoCotizacion($CotizacionIdFromFront){
        $this->postEditId = $CotizacionIdFromFront;

        $cotizacionDetailFromFront = Cotizacion::find($CotizacionIdFromFront);        
        //dd($cotizacionDetailFromFront);       

        $pedidoId = $cotizacionDetailFromFront['pedido_id'];
        //dd($pedidoId);
        
        $pedidoDetailFromFront = Pedido::find($pedidoId);        
        $this->pedidoDetail = $pedidoDetailFromFront; 
        //dd($this->pedidoDetail);       
        
        $clienteToFront = $pedidoDetailFromFront->load('cliente');        
        //dd($clienteToFront);
        $this->clienteDetail = $clienteToFront; 
        //dd($this->clienteDetail);

        $personaToFront = $pedidoDetailFromFront->load('cliente.persona');        
        //dd($personaToFront);
        $this->personaDetail = $personaToFront; 
        //dd($this->personaDetail);

        $detallesPedidoToFront = DetallePedido::where('pedido_id', $pedidoId)->get();             
        //dd($detallesPedidoToFront);

        $pedidoIdsServicios = [];
        foreach ($detallesPedidoToFront as $detallePedido) {
            $servicioId = $detallePedido->servicio_id;             
            // Añadir el servicio_id al array si no está presente                        
            if (!in_array($servicioId, $pedidoIdsServicios)) {
                $pedidoIdsServicios[] = $servicioId;
            }            
        }
        // Obtener los servicios con los IDs especificados
        $servicios = Servicio::whereIn('id', $pedidoIdsServicios)->get();        
        // Cargar las relaciones diseño, impresion, arquitectura, acondicionamiento
        $servicios->load('diseño', 'impresion', 'arquitectura', 'bastidor', 'acondicionamiento');        
        // Ahora $servicios contendrá cada servicio con sus relaciones cargadas si existen        
        // Inicializar un array para almacenar los datos formateados
        $resultado = [];        
        // Recorrer cada servicio y construir el array de resultados
        foreach ($servicios as $servicio) {
            $resultado[] = [
                'id' => $servicio->id,
                'descripcion' => $servicio->descripcion,
                'url' => $servicio->url,
                'diseño' => $servicio->diseño ? $servicio->diseño->toArray() : null,
                'impresion' => $servicio->impresion ? $servicio->impresion->toArray() : null,
                'arquitectura' => $servicio->arquitectura ? $servicio->arquitectura->toArray() : null,
                'bastidor' => $servicio->bastidor ? $servicio->bastidor->toArray() : null,
                'acondicionamiento' => $servicio->acondicionamiento ? $servicio->acondicionamiento->toArray() : null,
            ];
        }        
        //dd($resultado);
        //$this->resultadoDetail = $resultado;
        //dd($this->resultadoDetail);
        $this->resultadoDetail = $resultado;

        
        $this->openModalDetalleVerPedidoCotizacion = !$this->openModalDetalleVerPedidoCotizacion; 
    }

    public function enviarCotizacion(){  
        $this->validate([
            'postModalCotizacion.descripcioncotizacion' => 'required',
            'postModalCotizacion.costo' => 'required',            
            'postModalCotizacion.url' => 'required',            
        ]);
        
        //dd($this->postEditId);
        $cotizacion = Cotizacion::find($this->postEditId);
        
        $pedidoIdFromCotizacion = $cotizacion['pedido_id'];

        //$pedidoId = Pedido::find($this->postEditId);
        $pedido = Pedido::find($pedidoIdFromCotizacion);
        //dd($pedido);
        
        $cotizacion->update([
            'pedido_id' => $pedido->id,
            'descripcioncotizacion' => $this->postModalCotizacion['descripcioncotizacion'],      
            'costo' => $this->postModalCotizacion['costo'],      
            'url' => $this->postModalCotizacion['url'],      
        ]);
        $pedido->update([            
            'estado' => "Cotizado",                 
        ]);
        $this->reset(['postEditId']);        
        $this->openModalDetalleVerPedidoCotizacion = !$this->openModalDetalleVerPedidoCotizacion; 

        //Actualizar las cotizaciones para verlo reflejado en el front
        $this->cotizacions = Cotizacion::all();
        $this->mostrarModalEnviarCotizacion = true;
        
    }

    public $contador = 0;
    public $paginacion;
    
    public function incrementarPaginacion()
    {
        $this->paginacion = Paginacion::where('pagina', 'cotizacion')->first();
        $this->paginacion->increment('contador');
        //dd($this->paginacion);
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;

        //$this->incrementarPaginacion();
    }

    public function mount()
    {
        $this->cotizacions = Cotizacion::all();
        $this->incrementarPaginacion();
        //$this->cotizacions->load('pedido');        
    }

    public function render()
    {
        return view('livewire.formulario-cotizacion');
    }
}
