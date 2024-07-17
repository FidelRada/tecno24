<?php

namespace App\Livewire;

use App\Models\DetalleInsumo;
use App\Models\Insumo;
use App\Models\Paginacion;
use App\Models\Persona;
use App\Models\Personal;
use App\Models\Proveedor;
use Livewire\Component;
use App\Models\TipoMovimiento;
use App\Models\Movimiento;

class FormularioMovimiento extends Component
{
    public $openModalAgregarInsumo = false;
    public $openModalEditarInsumo = false;
    public $openModalVerDetalleMovimiento = false;
    public $mostrarProveedor = false;
    public $mostrarFormulario = false;

    public $mostrarModalSucessCreacionMovimiento = false;
    public $mostrarModalSucessCreacionInsumoMovimiento = false;
    public $mostrarModalSucessEditInsumoMovimiento = false;
    public $mostrarModalSucessDeleteInsumoMovimiento = false;
    public $mostrarModalEmptyInsumoMovimiento = false;

    public $detalleInsumo = [];

    public $insumos;
    public $tipos;
    public $movimientos;
    public $movimiento;
    public $proveedor;
    public $personal;
    public $detalleMovimiento;
    public $empleados;
    public $proveedores;

    public $postEdit;

    public $postCreate = [
        'motivo' => '',
        'fecha' => '',
        'id_tipo' => '',
        'id_personal' => '',
        'id_proveedor' => null
    ];
    public $postModalAgregarInsumo = [
        'id_insumo' => '',
        'cantidad' => '',
        'nombre_insumo' => ''
    ];
    public $postModalEdit = [
        'id_insumo' => '',
        'cantidad' => ''
    ];

    public function toggleCreateForm()
    {
        $this->resetValidation();
        $this->detalleInsumo = [];
        $this->mostrarFormulario = !$this->mostrarFormulario;
    }

    public function rules()
    {
        return [            
            'postCreate.motivo' => 'required',
            'postCreate.fecha' => 'required',
            'postCreate.id_personal' => 'required',
        ];
    }

    public function messages()
    {
        //dd($this->getErrorBag());              
        //$this->mostrarModalFailCreacion = true; 
        //$this->mostrarModalFailEdit = true; 
        //dd($this->getErrorBag());              
        return [
            'postCreate.motivo.required' => 'El Campo Motivo es requerido',
            'postCreate.fecha.required' => 'El Campo Motivo es requerido',
            'postCreate.id_personal.required' => 'El Campo Personal debe ser seleccionado',

            
            'postModalAgregarInsumo.cantidad.required' => 'El Campo Cantidad es requerido',
            'postModalAgregarInsumo.id_insumo.required' => 'El Campo Insumo debe ser seleccionado',
            
            'postModalEdit.cantidad.required' => 'El Campo Cantidad es requerido',
            'postModalEdit.id_insumo.required' => 'El Campo Insumo debe ser seleccionado',
        ];
        
    }

    public function saveModalAgregarInsumo()
    {   
        $this->resetValidation();
        $this->validate([            
            'postModalAgregarInsumo.cantidad' => 'required',
            'postModalAgregarInsumo.id_insumo' => 'required',
        ]);
        //dd($this->postModalAgregarInsumo['id_insumo']);
        $modelo_insumo = Insumo::find((int) $this->postModalAgregarInsumo['id_insumo']);
        //dd($modelo_insumo);
        $insumo = [
            'cantidad' => $this->postModalAgregarInsumo['cantidad'],
            'id_insumo' => $this->postModalAgregarInsumo['id_insumo'],
            'nombre_insumo' => $modelo_insumo['nombre'],
        ];

        $this->detalleInsumo[] = $insumo;

        $this->reset(['postModalAgregarInsumo']);
        $this->openModalAgregarInsumo = !$this->openModalAgregarInsumo;

        $this->mostrarModalSucessCreacionInsumoMovimiento = true;
        //dd($this->detalleInsumo);
    }

    public function editIsumo($index)
    {
        // Obtener el valor de 'servicio' del elemento en $detalleInsumo
        $detalle = $this->detalleInsumo[$index];
        $this->postEdit = $index;
        //dd($detalle);

        $this->postModalEdit['cantidad'] = $detalle['cantidad'];
        $this->postModalEdit['id_insumo'] = (int) $detalle['id_insumo'];

        $this->openModalEditarInsumo = !$this->openModalEditarInsumo;
        //dd($this->postModalEdit);

    }

    public function updateModalInsumo()
    {
        $this->validate([            
            'postModalEdit.cantidad' => 'required',
            'postModalEdit.id_insumo' => 'required',
        ]);
        $detalle = $this->detalleInsumo[$this->postEdit];
        //        dd($this->postModalEdit);
        //dd($detalle);

        $detalle['cantidad'] = $this->postModalEdit['cantidad'];

        if ($detalle['id_insumo'] !== (int) $this->postModalEdit['id_insumo']) {
            $insumoAct = Insumo::find((int) $this->postModalEdit['id_insumo']);
            $detalle['id_insumo'] = $this->postModalEdit['id_insumo'];
            $detalle['nombre_insumo'] = $insumoAct['nombre'];
        }

        $this->detalleInsumo[$this->postEdit] = $detalle;

        $this->openModalEditarInsumo = !$this->openModalEditarInsumo;
        $this->mostrarModalSucessEditInsumoMovimiento = true;

    }

    public function removeInsumo($index)
    {
        unset($this->detalleInsumo[$index]);
        // Reindexar el array para evitar problemas con índices
        $this->detalleInsumo = array_values($this->detalleInsumo);
        $this->mostrarModalSucessDeleteInsumoMovimiento = true;
    }

    public function verDetalle($id)
    {
        $this->openModalVerDetalleMovimiento = true;

        $this->movimiento = Movimiento::with(['tipoMovimiento'])->find($id);
        //dd($this->movimiento);

        $this->personal = Personal::with(['persona'])->find($this->movimiento['id_personal']);
        $this->proveedor = Proveedor::with(['persona'])->find($this->movimiento['id_proveedor']);


        $this->detalleMovimiento = DetalleInsumo::with('insumo')->where('id_movimiento', (int) $id)->get();
        //dd($this->detalle);


        //$this->actualizar();

    }

    public function save()
    {
        $D_Insumo = $this->detalleInsumo;    
        //dd(!$D_Insumo);   
        if(!empty($D_Insumo)){            
            //dd($this->detalleInsumo, $this->postCreate);
            $this->validate();
            $data = [
                'motivo' => $this->postCreate['motivo'],
                'fecha' => $this->postCreate['fecha'],
                'id_tipo' => 2,
                'id_proveedor' => null,
                'id_personal' => $this->postCreate['id_personal']
            ];

            if ($this->mostrarProveedor) {
                $data['id_proveedor'] = $this->postCreate['id_proveedor'];
                $data['id_tipo'] = 1;
                
            }

            //dd($data);
            $nuevo = Movimiento::create($data);

            //dd($nuevo);

            foreach ($this->detalleInsumo as $index => $detalle) {
                //dd($detalle);
                $nuevoDetalle = DetalleInsumo::create([
                    'id_insumo' => $detalle['id_insumo'],
                    'id_movimiento' => $nuevo['id'],
                    'cantidad' => $detalle['cantidad'],
                ]);
                //dd($nuevoDetalle);
            }

            reset($this->detalleInsumo);
            reset($this->postCreate);
            $this->postCreate['id_proveedor'] = null;
            $this->mostrarFormulario = !$this->mostrarFormulario;
            $this->actualizar();

            $this->mostrarModalSucessCreacionMovimiento = true;
        }else{
            $this->mostrarModalEmptyInsumoMovimiento = true;
        }
        

    }

    

    public function actualizar()
    {
        $this->insumos = Insumo::all();
        $this->tipos = TipoMovimiento::all();
        $this->movimientos = Movimiento::all();
        $this->empleados = Personal::with('persona')->get();
        $this->proveedores = Proveedor::with('persona')->get();
        $this->personal = Personal::with(['persona'])->first();
        $this->detalleMovimiento = [];
        //dd($this->proveedores);
    }

    public $contador = 0;
    public $paginacion;
    
    public function incrementarPaginacion()
    {
        $this->paginacion = Paginacion::where('pagina', 'movimiento')->first();
        $this->paginacion->increment('contador');
        //dd($this->paginacion);
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;

        //$this->incrementarPaginacion();
    }

    public function mount()
    {
        $this->actualizar();
        $this->incrementarPaginacion();
    }
    public function render()
    {
        //$tipos = TipoMovimiento::all();
        return view('livewire.formulario-movimiento');
    }

}
