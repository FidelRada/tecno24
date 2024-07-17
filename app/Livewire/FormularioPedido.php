<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Personal;
use App\Models\User;
use App\Models\Persona;
use App\Models\Servicio;
use App\Models\Diseño;
use App\Models\Impresion;
use App\Models\Arquitectura;
use App\Models\Bastidor;
use App\Models\Acondicionamiento;
use App\Models\Cotizacion;
use App\Models\DetallePedido;
use App\Models\Paginacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

use GuzzleHttp\Client;

class FormularioPedido extends Component
{
    public $pedidos;
    public $clientes;
    public $pedidoDetail = [];
    public $resultadoDetail = [];
    public $clienteDetail = [];
    public $personaDetail = [];
    public $cotizacionDetails = [];

    public $mostrarFormulario = false;
    public $mostrarModalSucessCreacionPedido = false;
    public $mostrarModalEmptyServicioPedido = false;
    public $mostrarModalSucessCreacionServicioPedido = false;
    public $mostrarModalSucessEditServicioPedido = false;
    public $mostrarModalSucessDeleteServicioPedido = false;
    public $mostrarModalEliminacionPedido = false;
    public $mostrarModalProcesarPedido = false;
    public $mostrarModalQRsucess = false;


    public $openModalDiseño = false;
    public $openModalImpresion = false;
    public $openModalArquitectura = false;
    public $openModalBastidor = false;
    public $openModalAcondicionamiento = false;

    public $openModalEditDiseño = false;
    public $openModalEditImpresion = false;
    public $openModalEditArquitectura = false;
    public $openModalEditBastidor = false;
    public $openModalEditAcondicionamiento = false;
    public $openModalCotizacion = false;
    
    public $mostrarQR = false;
    public $clickInProcessPago = false;    
    public $imageUrl;

    public $postEditIndex;

    public $detallePedidosServiciosArray = [];

    public $openModalDetallePedido = false;

    public $posts;
    public $postEditId = '';
    public $open = false;

    public $postCreate = [
        'descripciongeneral' => '',
        'fechaEntrega' => '',  
        'cliente_id' => '',       
    ];

    public $postModalDiseño = [        
        'descripcion' => '',
        'url' => '',          
    ];

    public $postModalEditDiseño = [        
        'descripcion' => '',
        'url' => '',          
    ];

    public $postModalImpresion = [        
        'descripcion' => '',
        'url' => '',          
        'material' => '',
        'ancho' => '',          
        'alto' => '',          
        'cantidad' => '',          
    ];

    public $postModalEditImpresion = [        
        'descripcion' => '',
        'url' => '',          
        'material' => '',
        'ancho' => '',          
        'alto' => '',          
        'cantidad' => '',          
    ];

    public $postModalArquitectura = [        
        'descripcion' => '',
        'url' => '',          
        'formato' => '',        
    ];

    public $postModalEditArquitectura = [        
        'descripcion' => '',
        'url' => '',          
        'formato' => '',        
    ];

    public $postModalBastidor = [        
        'descripcion' => '',
        'url' => '',          
        'material' => '',
        'ancho' => '',          
        'alto' => '',          
        'diseño' => '',          
    ];

    public $postModalEditBastidor = [        
        'descripcion' => '',
        'url' => '',          
        'material' => '',
        'ancho' => '',          
        'alto' => '',          
        'diseño' => '',          
    ];

    public $postModalAcondicionamiento = [        
        'descripcion' => '',
        'url' => '',          
        'formato' => '',        
    ];

    public $postModalEditAcondicionamiento = [        
        'descripcion' => '',
        'url' => '',          
        'formato' => '',        
    ];
    

    public function rules()
    {
        return [            
            'postCreate.descripciongeneral' => 'required',
            'postCreate.fechaEntrega' => 'required',
            'postCreate.cliente_id' => 'required',                        
            
        ];
    }

    public function messages()
    {
        return [            
            'postCreate.descripciongeneral.required' => 'El Campo Descripcion General es requerido',
            'postCreate.fechaEntrega.required' => 'El Campo Fecha de Entrega es requerido',
            'postCreate.cliente_id.required' => 'El Campo Cliente debe ser escogido',

            'postModalDiseño.descripcion.required' => 'El Campo Descripcion es requerido',
            'postModalDiseño.url.required' => 'El Campo Descripcion es requerido',

            'postModalEditDiseño.descripcion.required' => 'El Campo Descripcion es requerido',
            'postModalEditDiseño.url.required' => 'El Campo Descripcion es requerido',

            'postModalImpresion.descripcion.required' => 'El Campo Descripcion es requerido',
            'postModalImpresion.url.required' => 'El Campo url es requerido', 
            'postModalImpresion.material.required' => 'El Campo material es requerido',            
            'postModalImpresion.ancho.required' => 'El Campo Ancho es requerido',            
            'postModalImpresion.alto.required' => 'El Campo Alto es requerido',            
            'postModalImpresion.cantidad.required' => 'El Campo Cantidad es requerido',   

            'postModalEditImpresion.descripcion.required' => 'El Campo Descripcion es requerido',
            'postModalEditImpresion.url.required' => 'El Campo url es requerido', 
            'postModalEditImpresion.material.required' => 'El Campo material es requerido',            
            'postModalEditImpresion.ancho.required' => 'El Campo Ancho es requerido',            
            'postModalEditImpresion.alto.required' => 'El Campo Alto es requerido',            
            'postModalEditImpresion.cantidad.required' => 'El Campo Cantidad es requerido',   
            
            'postModalArquitectura.descripcion.required' => 'El Campo Descripcion es requerido',
            'postModalArquitectura.url.required' => 'El Campo url es requerido', 
            'postModalArquitectura.formato.required' => 'El Campo formato es requerido', 

            'postModalEditArquitectura.descripcion.required' => 'El Campo Descripcion es requerido',
            'postModalEditArquitectura.url.required' => 'El Campo url es requerido', 
            'postModalEditArquitectura.formato.required' => 'El Campo formato es requerido', 

            'postModalBastidor.descripcion.required' => 'El Campo Descripcion es requerido',
            'postModalBastidor.url.required' => 'El Campo url es requerido', 
            'postModalBastidor.material.required' => 'El Campo material es requerido',            
            'postModalBastidor.ancho.required' => 'El Campo Ancho es requerido',            
            'postModalBastidor.alto.required' => 'El Campo Alto es requerido',            
            'postModalBastidor.diseño.required' => 'El Campo Diseño es requerido',   

            'postModalEditBastidor.descripcion.required' => 'El Campo Descripcion es requerido',
            'postModalEditBastidor.url.required' => 'El Campo url es requerido', 
            'postModalEditBastidor.material.required' => 'El Campo material es requerido',            
            'postModalEditBastidor.ancho.required' => 'El Campo Ancho es requerido',            
            'postModalEditBastidor.alto.required' => 'El Campo Alto es requerido',            
            'postModalEditBastidor.diseño.required' => 'El Campo Diseño es requerido',   

            'postModalAcondicionamiento.descripcion.required' => 'El Campo Descripcion es requerido',
            'postModalAcondicionamiento.url.required' => 'El Campo url es requerido', 
            'postModalAcondicionamiento.formato.required' => 'El Campo formato es requerido', 

            'postModalEditAcondicionamiento.descripcion.required' => 'El Campo Descripcion es requerido',
            'postModalEditAcondicionamiento.url.required' => 'El Campo url es requerido', 
            'postModalEditAcondicionamiento.formato.required' => 'El Campo formato es requerido', 
            
        ];
    }

    /*
    public function validationAttributes(){
        return [
            'postCreate.category_id' => 'categoria'
        ];
    }
    */

    public function toggleCreateForm()
    {
        $this->resetValidation();
        $this->detallePedidosServiciosArray = [];
        $this->mostrarFormulario = !$this->mostrarFormulario;

        /*
        //$email = auth()->user()->email;
        $email = auth()->user();
        $clientData = $email->load('persona');


        dd($clientData);
        */

        
    }

    public function saveModalDiseño(){
        $this->resetValidation();
        $this->validate([
            'postModalDiseño.descripcion' => 'required',
            'postModalDiseño.url' => 'required',            
        ]);        
        $servicio = [            
            'descripcion' => $this->postModalDiseño['descripcion'],
            'url' => $this->postModalDiseño['url'],            
            'servicio' => 'diseño',
        ];
        $this->detallePedidosServiciosArray[] = $servicio;
        $this->reset(['postModalDiseño']);
        $this->openModalDiseño = !$this->openModalDiseño;

        $this->mostrarModalSucessCreacionServicioPedido = true;
    }

    public function saveModalImpresion(){  
        $this->resetValidation();
        $this->validate([
            'postModalImpresion.descripcion' => 'required',
            'postModalImpresion.url' => 'required', 
            'postModalImpresion.material' => 'required',            
            'postModalImpresion.ancho' => 'required',            
            'postModalImpresion.alto' => 'required',            
            'postModalImpresion.cantidad' => 'required',            
        ]);              
        $servicio = [            
            'descripcion' => $this->postModalImpresion['descripcion'],
            'url' => $this->postModalImpresion['url'],
            'material' => $this->postModalImpresion['material'],
            'ancho' => $this->postModalImpresion['ancho'],
            'alto' => $this->postModalImpresion['alto'],
            'cantidad' => $this->postModalImpresion['cantidad'],
            
            'servicio' => 'impresion',
            // Agrega más campos según sea necesario para cada tipo de modal
        ];

        $this->detallePedidosServiciosArray[] = $servicio;
        $this->reset(['postModalImpresion']);
        $this->openModalImpresion = !$this->openModalImpresion;

        //dd($this->detallePedidosServiciosArray);
        $this->mostrarModalSucessCreacionServicioPedido = true;
    }

    public function saveModalArquitectura(){   
        $this->validate([
            'postModalArquitectura.descripcion' => 'required',
            'postModalArquitectura.url' => 'required',            
            'postModalArquitectura.formato' => 'required',            
        ]);             
        $servicio = [            
            'descripcion' => $this->postModalArquitectura['descripcion'],
            'url' => $this->postModalArquitectura['url'],
            'formato' => $this->postModalArquitectura['formato'],
            // Agrega más campos según sea necesario para cada tipo de modal
            'servicio' => 'arquitectura',
        ];

        $this->detallePedidosServiciosArray[] = $servicio;
        $this->reset(['postModalArquitectura']);
        $this->openModalArquitectura = !$this->openModalArquitectura;

        //dd($this->detallePedidosServiciosArray);
        $this->mostrarModalSucessCreacionServicioPedido = true;
    }

    public function saveModalBastidor(){        
        $this->validate([
            'postModalBastidor.descripcion' => 'required',
            'postModalBastidor.url' => 'required', 
            'postModalBastidor.material' => 'required',            
            'postModalBastidor.ancho' => 'required',            
            'postModalBastidor.alto' => 'required',            
            'postModalBastidor.diseño' => 'required',            
        ]);
        $servicio = [            
            'descripcion' => $this->postModalBastidor['descripcion'],
            'url' => $this->postModalBastidor['url'],
            'material' => $this->postModalBastidor['material'],
            'ancho' => $this->postModalBastidor['ancho'],
            'alto' => $this->postModalBastidor['alto'],
            'diseño' => $this->postModalBastidor['diseño'],

            'servicio' => 'bastidor',
            // Agrega más campos según sea necesario para cada tipo de modal
        ];

        $this->detallePedidosServiciosArray[] = $servicio;
        $this->reset(['postModalBastidor']);
        $this->openModalBastidor = !$this->openModalBastidor;

        //dd($this->detallePedidosServiciosArray);
        $this->mostrarModalSucessCreacionServicioPedido = true;
    }

    public function saveModalAcondicionamiento(){    
        $this->validate([
            'postModalAcondicionamiento.descripcion' => 'required',
            'postModalAcondicionamiento.url' => 'required',            
            'postModalAcondicionamiento.formato' => 'required',            
        ]);                 
        $servicio = [            
            'descripcion' => $this->postModalAcondicionamiento['descripcion'],
            'url' => $this->postModalAcondicionamiento['url'],
            'formato' => $this->postModalAcondicionamiento['formato'],
            // Agrega más campos según sea necesario para cada tipo de modal
            'servicio' => 'acondicionamiento',
        ];

        $this->detallePedidosServiciosArray[] = $servicio;
        $this->reset(['postModalAcondicionamiento']);
        $this->openModalAcondicionamiento = !$this->openModalAcondicionamiento;

        //dd($this->detallePedidosServiciosArray);
        $this->mostrarModalSucessCreacionServicioPedido = true;
    }

    public function editModal($index) {
        // Obtener el valor de 'servicio' del elemento en $detallePedidosServiciosArray
        $servicio = $this->detallePedidosServiciosArray[$index]['servicio'];
        $this->postEditIndex = $index;
    
        // Utilizar un switch para comparar el valor de 'servicio'
        switch ($servicio) {
            case 'diseño':
                $this->openModalEditDiseño = !$this->openModalEditDiseño;
                $this->postModalEditDiseño['descripcion'] = $this->detallePedidosServiciosArray[$index]['descripcion'];
                $this->postModalEditDiseño['url'] = $this->detallePedidosServiciosArray[$index]['url'];                                        
                break;
            case 'impresion':
                $this->openModalEditImpresion = !$this->openModalEditImpresion;
                $this->postModalEditImpresion['descripcion'] = $this->detallePedidosServiciosArray[$index]['descripcion'];
                $this->postModalEditImpresion['url'] = $this->detallePedidosServiciosArray[$index]['url'];
                $this->postModalEditImpresion['material'] = $this->detallePedidosServiciosArray[$index]['material'];
                $this->postModalEditImpresion['ancho'] = $this->detallePedidosServiciosArray[$index]['ancho'];
                $this->postModalEditImpresion['alto'] = $this->detallePedidosServiciosArray[$index]['alto'];                                        
                $this->postModalEditImpresion['cantidad'] = $this->detallePedidosServiciosArray[$index]['cantidad'];                                        
                break;
            case 'arquitectura':
                $this->openModalEditArquitectura = !$this->openModalEditArquitectura;
                $this->postModalEditArquitectura['descripcion'] = $this->detallePedidosServiciosArray[$index]['descripcion'];
                $this->postModalEditArquitectura['url'] = $this->detallePedidosServiciosArray[$index]['url'];                                        
                $this->postModalEditArquitectura['formato'] = $this->detallePedidosServiciosArray[$index]['formato'];                                        
                break;
            case 'bastidor':
                $this->openModalEditBastidor = !$this->openModalEditBastidor;
                $this->postModalEditBastidor['descripcion'] = $this->detallePedidosServiciosArray[$index]['descripcion'];
                $this->postModalEditBastidor['url'] = $this->detallePedidosServiciosArray[$index]['url'];
                $this->postModalEditBastidor['material'] = $this->detallePedidosServiciosArray[$index]['material'];
                $this->postModalEditBastidor['ancho'] = $this->detallePedidosServiciosArray[$index]['ancho'];
                $this->postModalEditBastidor['alto'] = $this->detallePedidosServiciosArray[$index]['alto'];                                        
                $this->postModalEditBastidor['diseño'] = $this->detallePedidosServiciosArray[$index]['diseño'];                                        
                break;
            case 'acondicionamiento':
                $this->openModalEditAcondicionamiento = !$this->openModalEditAcondicionamiento;
                $this->postModalEditAcondicionamiento['descripcion'] = $this->detallePedidosServiciosArray[$index]['descripcion'];
                $this->postModalEditAcondicionamiento['url'] = $this->detallePedidosServiciosArray[$index]['url'];                                        
                $this->postModalEditAcondicionamiento['formato'] = $this->detallePedidosServiciosArray[$index]['formato'];                                        
                break;
            default:
                // En caso de que 'servicio' no coincida con ninguno de los casos anteriores
                echo 'No hay servicio específico';
                break;
        }
    }

    public function updateModal(){ 
        $servicio = $this->detallePedidosServiciosArray[$this->postEditIndex];
        $serviciotipo = $this->detallePedidosServiciosArray[$this->postEditIndex]['servicio'];

        // Utilizar un switch para comparar el valor de 'servicio'
        switch ($serviciotipo) {
            case 'diseño':
                $this->validate([
                    'postModalEditDiseño.descripcion' => 'required',
                    'postModalEditDiseño.url' => 'required',            
                ]); 
                $servicio['descripcion'] = $this->postModalEditDiseño['descripcion'];
                $servicio['url'] = $this->postModalEditDiseño['url'];      

                $this->detallePedidosServiciosArray[$this->postEditIndex] = $servicio;        
                $this->reset(['postEditIndex', 'postModalEditDiseño']);
                $this->openModalEditDiseño = !$this->openModalEditDiseño;
                $this->mostrarModalSucessEditServicioPedido = true;
                break;
            case 'impresion':
                $this->validate([
                    'postModalEditImpresion.descripcion' => 'required',
                    'postModalEditImpresion.url' => 'required', 
                    'postModalEditImpresion.material' => 'required',            
                    'postModalEditImpresion.ancho' => 'required',            
                    'postModalEditImpresion.alto' => 'required',            
                    'postModalEditImpresion.cantidad' => 'required',            
                ]);              
                $servicio['descripcion'] = $this->postModalEditImpresion['descripcion'];
                $servicio['url'] = $this->postModalEditImpresion['url'];
                $servicio['material'] = $this->postModalEditImpresion['material'];
                $servicio['ancho'] = $this->postModalEditImpresion['ancho'];
                $servicio['alto'] = $this->postModalEditImpresion['alto'];                                        
                $servicio['cantidad'] = $this->postModalEditImpresion['cantidad'];                                        

                $this->detallePedidosServiciosArray[$this->postEditIndex] = $servicio;        
                $this->reset(['postEditIndex', 'postModalEditImpresion']);
                $this->openModalEditImpresion = !$this->openModalEditImpresion;
                $this->mostrarModalSucessEditServicioPedido = true;
                break;
            case 'arquitectura': 
                $this->validate([
                    'postModalEditArquitectura.descripcion' => 'required',
                    'postModalEditArquitectura.url' => 'required',            
                    'postModalEditArquitectura.formato' => 'required',            
                ]);               
                $servicio['descripcion'] = $this->postModalEditArquitectura['descripcion'];
                $servicio['url'] = $this->postModalEditArquitectura['url'];                                        
                $servicio['formato'] = $this->postModalEditArquitectura['formato'];                                        

                $this->detallePedidosServiciosArray[$this->postEditIndex] = $servicio;        
                $this->reset(['postEditIndex', 'postModalEditArquitectura']);
                $this->openModalEditArquitectura = !$this->openModalEditArquitectura;
                $this->mostrarModalSucessEditServicioPedido = true;
                break;
            case 'bastidor':
                $this->validate([
                    'postModalEditBastidor.descripcion' => 'required',
                    'postModalEditBastidor.url' => 'required', 
                    'postModalEditBastidor.material' => 'required',            
                    'postModalEditBastidor.ancho' => 'required',            
                    'postModalEditBastidor.alto' => 'required',            
                    'postModalEditBastidor.diseño' => 'required',            
                ]);                
                $servicio['descripcion'] = $this->postModalEditBastidor['descripcion'];
                $servicio['url'] = $this->postModalEditBastidor['url'];
                $servicio['material'] = $this->postModalEditBastidor['material'];
                $servicio['ancho'] = $this->postModalEditBastidor['ancho'];
                $servicio['alto'] = $this->postModalEditBastidor['alto'];                                        
                $servicio['diseño'] = $this->postModalEditBastidor['diseño'];                                        
                
                $this->detallePedidosServiciosArray[$this->postEditIndex] = $servicio;        
                $this->reset(['postEditIndex', 'postModalEditBastidor']);
                $this->openModalEditBastidor = !$this->openModalEditBastidor;
                $this->mostrarModalSucessEditServicioPedido = true;
                break;
            case 'acondicionamiento':
                $this->validate([
                    'postModalEditAcondicionamiento.descripcion' => 'required',
                    'postModalEditAcondicionamiento.url' => 'required',            
                    'postModalEditAcondicionamiento.formato' => 'required',            
                ]);                 
                $servicio['descripcion'] = $this->postModalEditAcondicionamiento['descripcion'];
                $servicio['url'] = $this->postModalEditAcondicionamiento['url'];                                        
                $servicio['formato'] = $this->postModalEditAcondicionamiento['formato'];                                        
                
                $this->detallePedidosServiciosArray[$this->postEditIndex] = $servicio;        
                $this->reset(['postEditIndex', 'postModalEditAcondicionamiento']);
                $this->openModalEditAcondicionamiento = !$this->openModalEditAcondicionamiento;
                $this->mostrarModalSucessEditServicioPedido = true;
                break;
            default:
                // En caso de que 'servicio' no coincida con ninguno de los casos anteriores
                echo 'No hay servicio específico para actualizar';
                break;
        }
    }    

    public function deleteModal($index){
        unset($this->detallePedidosServiciosArray[$index]);        
        $this->detallePedidosServiciosArray = array_values($this->detallePedidosServiciosArray);
        $this->mostrarModalSucessDeleteServicioPedido = true;        
    }
    
    public function save()
    {
        $D_pedido_check = $this->detallePedidosServiciosArray;
        //dd($this->detallePedidosServiciosArray);   
        //dd(!empty($D_pedido_check));   
        if(!empty($D_pedido_check)){
            $this->validate();
            //dd($this->postCreate['rolpersonal']);
            //dd($this->detallePedidosServiciosArray);
            
            // Crear y guardar el pedido asociado al cliente
            $pedidoCreated = Pedido::create([            
                'descripciongeneral' => $this->postCreate['descripciongeneral'],     
                'fechaEntrega' => $this->postCreate['fechaEntrega'],     
                'cliente_id' => $this->postCreate['cliente_id'],     
                'estado' => 'Pendiente',                 
            ]);
            
            
            // Iterar sobre cada servicio en $detallePedidosServiciosArray
            foreach ($this->detallePedidosServiciosArray as $index => $servicio) {
                // Crear y guardar el servicio asociado al pedido
                
                $servicioCreated = Servicio::create([                                
                    'descripcion' => $servicio['descripcion'],
                    'url' => $servicio['url'],                
                ]);           

                //$serviciotipo = $this->servicio[$this->index]['servicio'];            
                $serviciotipo = $servicio['servicio'];
                switch ($serviciotipo) {
                    case 'diseño':
                        $disenoCreated = Diseño::create([
                            'descripcion' => $servicio['descripcion'],
                            'url' => $servicio['url'],  
                            'servicio_id' => $servicioCreated->id    
                        ]);                    
                        $detallePedidoCreated = DetallePedido::create([
                            'pedido_id' => $pedidoCreated->id,
                            'servicio_id' => $servicioCreated->id
                        ]);
                        break;
                    case 'impresion':
                        $impresionCreated = Impresion::create([
                            'descripcion' => $servicio['descripcion'],
                            'url' => $servicio['url'],      
                            'material' => $servicio['material'],
                            'ancho' => $servicio['ancho'],
                            'alto' => $servicio['alto'],                                        
                            'cantidad' => $servicio['cantidad'],                                        
                            'servicio_id' => $servicioCreated->id
                        ]);                    
                        $detallePedidoCreated = DetallePedido::create([
                            'pedido_id' => $pedidoCreated->id,
                            'servicio_id' => $servicioCreated->id
                        ]);                    
                        break;
                    case 'arquitectura':                
                        $arquitecturaCreated = Arquitectura::create([
                            'descripcion' => $servicio['descripcion'],
                            'url' => $servicio['url'],
                            'formato' => $servicio['formato'],
                            'servicio_id' => $servicioCreated->id    
                        ]);                    
                        $detallePedidoCreated = DetallePedido::create([
                            'pedido_id' => $pedidoCreated->id,
                            'servicio_id' => $servicioCreated->id
                        ]);                    
                        break;
                    case 'bastidor':                
                        $bastidorCreated = Bastidor::create([
                            'descripcion' => $servicio['descripcion'],
                            'url' => $servicio['url'],      
                            'material' => $servicio['material'],
                            'ancho' => $servicio['ancho'],
                            'alto' => $servicio['alto'],                                        
                            'diseño' => $servicio['diseño'],                                        
                            'servicio_id' => $servicioCreated->id
                        ]);                    
                        $detallePedidoCreated = DetallePedido::create([
                            'pedido_id' => $pedidoCreated->id,
                            'servicio_id' => $servicioCreated->id
                        ]);
                        break;
                    case 'acondicionamiento':
                        $acondicionamientoCreated = Acondicionamiento::create([
                            'descripcion' => $servicio['descripcion'],
                            'url' => $servicio['url'],
                            'formato' => $servicio['formato'],
                            'servicio_id' => $servicioCreated->id    
                        ]);                    
                        $detallePedidoCreated = DetallePedido::create([
                            'pedido_id' => $pedidoCreated->id,
                            'servicio_id' => $servicioCreated->id
                        ]);                    
                        break;
                    default:                        
                        echo 'No hay servicio específico para actualizar';
                        break;
                }
                
            }
            $this->mostrarFormulario = false;
            $this->reset(['postCreate']);
            $this->detallePedidosServiciosArray = [];        
            $this->pedidos = Pedido::all();

            $this->mostrarModalSucessCreacionPedido = true;
        }else{
            $this->mostrarModalEmptyServicioPedido = true;
        }
    }
    
    public function destroy($postId){  
        $detallesPedido1 = DetallePedido::where('pedido_id', $postId)->get();             
        $pedidoDelete = Pedido::find($postId);
        $serviciosIds = [];
        foreach ($detallesPedido1 as $detallePedido) {
            $servicioId = $detallePedido->servicio_id;
            // Añadir el servicio_id al array si no está presente
            if (!in_array($servicioId, $serviciosIds)) {
                $serviciosIds[] = $servicioId;
            }
        }
        // Eliminar cada Servicio encontrado en $serviciosIds
        foreach ($serviciosIds as $servicioId) {
            Servicio::where('id', $servicioId)->delete();
        }
        // Eliminar el Pedido si lo deseas
        $pedido = Pedido::find($postId);
        if ($pedido) {
            $pedido->delete();
        }
        // Opcionalmente, actualizar la lista de Pedidos después de la eliminación
        $this->pedidos = Pedido::all();
        $this->mostrarFormulario = false;  
        
        $this->mostrarModalEliminacionPedido= true; 
    }

    public function detallePedidoFromFront($PedidoIdFromFront){
        $this->postEditId = $PedidoIdFromFront;

        $pedidoDetailFromFront = Pedido::find($PedidoIdFromFront);        
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

        $detallesPedidoToFront = DetallePedido::where('pedido_id', $PedidoIdFromFront)->get();             
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
        $this->openModalDetallePedido = !$this->openModalDetallePedido; 
    }

    public function procesarPedido(){
        //dd($this->postEditId);
        $pedidoId = Pedido::find($this->postEditId);
        $cotizacionCreated = Cotizacion::create([
            'pedido_id' => $pedidoId->id,
            'descripcioncotizacion' => '',      
            'costo' => '',      
            'url' => '',      
        ]);
        $pedidoId->update([            
            'estado' => "Cotizando",                 
        ]);
        $this->reset(['postEditId']);        
        $this->openModalDetallePedido = !$this->openModalDetallePedido; 

        //Actualizar pedidos para verlo reflejado en el front
        $this->pedidos = Pedido::all();
        $this->mostrarModalProcesarPedido = true;
    }

    public function verCotizacion($pedidoId){
        $this->postEditId = $pedidoId;
        $cotizacion = Cotizacion::where('pedido_id', $pedidoId)->first();
        //dd($cotizacion);
        $cotizacionDetail[] = [
            'descripcioncotizacion' => $cotizacion['descripcioncotizacion'],
            'costo' => $cotizacion['costo'],
            'url' => $cotizacion['url'],
        ];

        $this->cotizacionDetails = $cotizacionDetail;
        //dd($this->cotizacionDetails);           
        $this->openModalCotizacion = !$this->openModalCotizacion;     
    }

    

    public function procesarPagoQR(){        
        $pedidoD = Pedido::find($this->postEditId);
        $pedidoIdToCallBack = $pedidoD->id;
        //dd($pedidoIdToCallBack);
        //dd($pedido);

        $cotizacionD = Cotizacion::where('pedido_id', $this->postEditId)->first();
        //dd($cotizacionD);
        $monto = $cotizacionD->costo;

        $clienteD = $pedidoD->load('cliente');        
        //dd($clienteD);
        //dd($clienteD->cliente->nit);
        $nit = $pedidoD->cliente->nit;

        $personaD = $pedidoD->load('cliente.persona');        
        //dd($personaD->cliente->persona->nombre);
        $nombre = $personaD->cliente->persona->nombre;
        $apellidoPaterno = $personaD->cliente->persona->apellidopaterno;
        $apellidoMaterno = $personaD->cliente->persona->apellidomaterno;
        $nombreCompleto = "$nombre $apellidoPaterno $apellidoMaterno";
        //dd($nombreCompleto);        
        $telefono = $pedidoD->cliente->persona->telefono;

        // Suponiendo que $pedidoD es el objeto Pedido con la relación cargada 'cliente.persona'
        $persona_id = $pedidoD->cliente->persona->id;
        //dd($persona_id);
        $usuarioD = User::where('person_id', $persona_id)->first();
        $email = $usuarioD->email;
        //dd($usuarioD->email);
        //dd($email);        
        $pedidoDetalleD = [];
        $pedidoDetalleDe = [
            'Serial' => '111',
            'Producto' => 'Polera',
            'Cantidad' => '1',
            'Precio' => '0.01',
            'Descuento' => '0',
            'Total' => '0.01',
        ];
        $pedidoDetalleD[0] = $pedidoDetalleDe;

        //$pedidoDetalleD[0]['total'] = 200;
        //dd($pedidoDetalleD);

        $tnTipoServicio = 1; // Valor por defecto para el tipo de servicio de QR
        
        /*
        $loClient = new Client();
        $loUserAuth = $loClient->post(
            'https://serviciostigomoney.pagofacil.com.bo/api/auth/login', [
            'headers' => ['Accept' => 'application/json'],
            'json' => array(
            'TokenService' => "51247fae280c20410824977b0781453df59fad5b23bf2a0d14e884482f91e09078dbe5966e0b970ba696ec4caf9aa5661802935f86717c481f1670e63f35d5041c31d7cc6124be82afedc4fe926b806755efe678917468e31593a5f427c79cdf016b686fca0cb58eb145cf524f62088b57c6987b3bb3f30c2082b640d7c52907",
            'TokenSecret' => "9E7BC239DDC04F83B49FFDA5"
        )]);        
        $laTokenAuth = json_decode($loUserAuth->getBody()->getContents());
        //dd($laTokenAuth);
        */ 
        
        $timestamp = time(); // Obtener el timestamp actual
        $timestamp_str = (string) $timestamp; // Convertir el timestamp a cadena

        // Obtener los últimos 5 caracteres
        $ultimos_cinco = substr($timestamp_str, -5);
        //dd($ultimos_cinco);
                
        try{     
            $lcComerceID = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";
            $lnMoneda = 2;                                  //Moneda Boliviana
            $lcNombreUsuario = $nombreCompleto;             //Nombre del Usuario o Razon Social
            $lnCiNit = $nit;                                //CI del Cliente
            $lnTelefono = $telefono;                        //Telefono del Cliente
            $lcNroPago = "UAGRM-SA-GRUPO10".$ultimos_cinco."*".$pedidoIdToCallBack;         //Grupo de la materia            
            //$lnMontoClienteEmpresa = $monto;                //Monto del Pago
            $lnMontoClienteEmpresa = 0.01;                //Monto del Pago
            $lcCorreo = $email;                             //Email del Cliente
            $lcUrlCallBack = "http://fidelrada.tecnologia.bo/registrarPago";
            //"https://www.tecnoweb.org.bo/inf513/grupo10sa/registrarPago";//"https://e329-181-41-158-54.ngrok-free.app/registrarPago";           
            $lcUrlReturn = "";                              //por default es: "http://localhost:8000/"
            $laPedidoDetalle = $pedidoDetalleD;             //Detalle
            $lcUrl = "";

            $loClient = new Client();

            if ($tnTipoServicio == 1) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";
            } elseif ($tnTipoServicio == 2) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/realizarpagotigomoneyv2";
            } 

            $laHeader = [
                'Accept' => 'application/json'
            ];

            $laBody = [
                "tcCommerceID" => $lcComerceID,
                "tnMoneda" => $lnMoneda,
                "tnTelefono" => $lnTelefono,
                'tcNombreUsuario' => $lcNombreUsuario,
                'tnCiNit' => $lnCiNit,
                'tcNroPago' => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo" => $lcCorreo,
                'tcUrlCallBack' => $lcUrlCallBack,
                "tcUrlReturn" => $lcUrlReturn,
                'taPedidoDetalle' => $laPedidoDetalle
            ];
            

            //dd($laBody);

            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);
            //dd($loResponse);

            $laResult = json_decode($loResponse->getBody()->getContents());            
            //dd($laResult);

            if ($tnTipoServicio == 1) {
                $laValues = explode(";", $laResult->values)[1];
                $laQrImage = "data:image/png;base64," . json_decode($laValues)->qrImage;
                $this->imageUrl = $laQrImage;                
                //dd($laQrImage);
                //echo '<img src="' . $laQrImage . '" alt="Imagen base64">';
                
            }

            $this->mostrarQR = !$this->mostrarQR;
            $this->mostrarModalQRsucess = true;            
            $this->clickInProcessPago = !$this->clickInProcessPago;            

        } catch (\Throwable $th) {  
            dd($th->getMessage() . " - " . $th->getLine());          
            return $th->getMessage() . " - " . $th->getLine();
        }
        /*
        $this->mostrarQR = !$this->mostrarQR;
        $this->clickInProcessPago = !$this->clickInProcessPago;
        */       
        
    }



    public function cancelarPagoQR(){
        if($this->mostrarQR){
            $this->mostrarQR = !$this->mostrarQR;
        }
        if($this->clickInProcessPago){
            $this->clickInProcessPago = !$this->clickInProcessPago;
        }
        $this->openModalCotizacion = !$this->openModalCotizacion;
    }

    public $contador = 0;
    public $paginacion;
    
    public function incrementarPaginacion()
    {
        $this->paginacion = Paginacion::where('pagina', 'pedido')->first();
        $this->paginacion->increment('contador');
        //dd($this->paginacion);
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;

        //$this->incrementarPaginacion();
    }

    public function mount()
    {
        $this->pedidos = Pedido::all();
        $this->clientes = Cliente::with('persona')->get();
        $this->incrementarPaginacion();
    }    

    public function render()
    {
        return view('livewire.formulario-pedido');
    }
}






/*
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ConsumirServicioController extends Controller
{
    public function RecolectarDatos(Request $request)
    {
        try {
            $lcComerceID           = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";
            $lnMoneda              = 2;
            $lnTelefono            = $request->tnTelefono;       //Celular o Telefono  
            $lcNombreUsuario       = $request->tcRazonSocial;    //Nombre del Usuario = razon Social
            $lnCiNit               = $request->tcCiNit;          //CI/NIT
            $lcNroPago             = "UAGRM-SC-GRUPO1-1"     ;   //Grupo de la materia   
            $lnMontoClienteEmpresa = $request->tnMonto;          //Monto Total del QR
            $lcCorreo              = $request->tcCorreo;         //Correo Electronico 
            $lcUrlCallBack         = "http://localhost:8000/";   
            $lcUrlReturn           = "http://localhost:8000/";
            $laPedidoDetalle       = $request->taPedidoDetalle;
            $lcUrl                 = "";

            $loClient = new Client();

            if ($request->tnTipoServicio == 1) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";
            } elseif ($request->tnTipoServicio == 2) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/realizarpagotigomoneyv2";
            }

            $laHeader = [
                'Accept' => 'application/json'
            ];

            $laBody   = [
                "tcCommerceID"          => $lcComerceID,
                "tnMoneda"              => $lnMoneda,
                "tnTelefono"            => $lnTelefono,
                'tcNombreUsuario'       => $lcNombreUsuario,
                'tnCiNit'               => $lnCiNit,
                'tcNroPago'             => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo"              => $lcCorreo,
                'tcUrlCallBack'         => $lcUrlCallBack,
                "tcUrlReturn"           => $lcUrlReturn,
                'taPedidoDetalle'       => $laPedidoDetalle
            ];

            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);

            $laResult = json_decode($loResponse->getBody()->getContents());

            if ($request->tnTipoServicio == 1) {

                $laValues = explode(";", $laResult->values)[1];
           

                $laQrImage = "data:image/png;base64," . json_decode($laValues)->qrImage;
                echo '<img src="' . $laQrImage . '" alt="Imagen base64">';
            } elseif ($request->tnTipoServicio == 2) {

             
                
                $csrfToken = csrf_token();

                echo '<h5 class="text-center mb-4">' . $laResult->message . '</h5>';
                echo '<p class="blue-text">Transacción Generada: </p><p id="tnTransaccion" class="blue-text">'. $laResult->values . '</p><br>';
                echo '<iframe name="QrImage" style="width: 100%; height: 300px;"></iframe>';
                echo '<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>';

                echo '<script>
                        $(document).ready(function() {
                            function hacerSolicitudAjax(numero) {
                                // Agrega el token CSRF al objeto de datos
                                var data = { _token: "' . $csrfToken . '", tnTransaccion: numero };
                                
                                $.ajax({
                                    url: \'/consultar\',
                                    type: \'POST\',
                                    data: data,
                                    success: function(response) {
                                        var iframe = document.getElementsByName(\'QrImage\')[0];
                                        iframe.contentDocument.open();
                                        iframe.contentDocument.write(response.message);
                                        iframe.contentDocument.close();
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });
                            }

                            setInterval(function() {
                                hacerSolicitudAjax(' . $laResult->values . ');
                            }, 7000);
                        });
                    </script>';


            
            }
        } catch (\Throwable $th) {

            return $th->getMessage() . " - " . $th->getLine();
        }
    }

    public function ConsultarEstado(Request $request)
    {
        $lnTransaccion = $request->tnTransaccion;
        
        $loClientEstado = new Client();

        $lcUrlEstadoTransaccion = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/consultartransaccion";

        $laHeaderEstadoTransaccion = [
            'Accept' => 'application/json'
        ];

        $laBodyEstadoTransaccion = [
            "TransaccionDePago" => $lnTransaccion
        ];

        $loEstadoTransaccion = $loClientEstado->post($lcUrlEstadoTransaccion, [
            'headers' => $laHeaderEstadoTransaccion,
            'json' => $laBodyEstadoTransaccion
        ]);

        $laResultEstadoTransaccion = json_decode($loEstadoTransaccion->getBody()->getContents());

        $texto = '<h5 class="text-center mb-4">Estado Transacción: ' . $laResultEstadoTransaccion->values->messageEstado . '</h5><br>';

        return response()->json(['message' => $texto]);
    }

    public function urlCallback(Request $request)
    {
        $Venta = $request->input("PedidoID");
        $Fecha = $request->input("Fecha");
        $NuevaFecha = date("Y-m-d", strtotime($Fecha));
        $Hora = $request->input("Hora");
        $MetodoPago = $request->input("MetodoPago");
        $Estado = $request->input("Estado");
        $Ingreso = true;

        try {
          //  propceso de verificacion y procesando el pago ya en el lado del comercio
            $arreglo = ['error' => 0, 'status' => 1, 'message' => "Pago realizado correctamente.", 'values' => true];
        } catch (\Throwable $th) {
            $arreglo = ['error' => 1, 'status' => 1, 'messageSistema' => "[TRY/CATCH] " . $th->getMessage(), 'message' => "No se pudo realizar el pago, por favor intente de nuevo.", 'values' => false];
        }

        return response()->json($arreglo);
    }
}
*/
