<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\CategoriaInsumo;
use App\Models\Insumo;
use App\Models\Paginacion;

class FormularioInsumo extends Component
{
    public $insumos;
    public $categoriainsumos;

    public $mostrarFormulario = false;
    public $mostrarModalSucessCreacion = false;    
    //public $mostrarModalFailCreacion = false;    
    public $mostrarModalSucessEdit = false;    
    //public $mostrarModalFailEdit = false;    
    public $mostrarModalEliminacion = false;    

    public $postCreate = [        
        'nombre' => '',
        'marca' => '',        
        'origen' => '',
        'categoria_insumo_id' => ''
    ];

    public $posts;

    public $postEditId = '';

    public $open = false;

    public $postEdit = [        
        'nombre' => '',
        'marca' => '',        
        'origen' => '',
        'categoria_insumo_id' => ''
    ];

    public function rules(){
        return [
            'postCreate.nombre' => 'required',
            'postCreate.marca' => 'required',
            'postCreate.origen' => 'required',
            'postCreate.categoria_insumo_id' => 'required'
        ];
    }

    public function messages(){
        return [
            'postCreate.nombre.required' => 'El Campo Nombre es requerido',
            'postCreate.marca.required' => 'El Campo Marca es requerido',
            'postCreate.origen.required' => 'El Campo Origen es requerido',
            'postCreate.categoria_insumo_id.required' => 'El Campo Categoria del Insumo debe ser escogido',

            'postEdit.nombre.required' => 'El Campo Nombre es requerido',
            'postEdit.marca.required' => 'El Campo Marca es requerido',
            'postEdit.origen.required' => 'El Campo Origen es requerido',
            'postEdit.categoria_insumo_id.required' => 'El Campo Categoria del Insumo debe ser escogido',


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
        $this->mostrarFormulario = !$this->mostrarFormulario;
    }
    
    
    public function save(){

        $this->validate();       
        
        
        $insumo = Insumo::create([
            'categoria_insumo_id' => $this->postCreate['categoria_insumo_id'],
            'nombre' => $this->postCreate['nombre'],
            'marca' => $this->postCreate['marca'],
            'origen' => $this->postCreate['origen'],
        ]);
        $this->mostrarFormulario = false;
        $this->reset(['postCreate']);

        $this->insumos = Insumo::all();
        $this->mostrarModalSucessCreacion = true;        
    }

    public function edit($postId){
        $this->resetValidation();
        $this->mostrarFormulario = false;        
        $this->open = true;

        $this->postEditId = $postId;

        $insumo = Insumo::find($postId);
        //dd($insumo);

        $this->postEdit['nombre'] = $insumo->nombre;
        $this->postEdit['marca'] = $insumo->marca;
        $this->postEdit['origen'] = $insumo->origen;
        $this->postEdit['categoria_insumo_id'] = $insumo->categoria_insumo_id;        
    }

    public function update(){ 
        $this->validate([
            'postEdit.nombre' => 'required',
            'postEdit.marca' => 'required',
            'postEdit.origen' => 'required',
            'postEdit.categoria_insumo_id' => 'required'
        ]);
        
        

        $insumo = Insumo::find($this->postEditId);

        $insumo->update([
            'categoria_insumo_id' => $this->postEdit['categoria_insumo_id'],
            'nombre' => $this->postEdit['nombre'],
            'marca' => $this->postEdit['marca'],
            'origen' => $this->postEdit['origen']
        ]);
        $this->mostrarFormulario = false;
        $this->reset(['postEditId', 'postEdit', 'open']);
        $this->insumos = Insumo::all();
        $this->mostrarModalSucessEdit = true;        
    }

    public function destroy($postId){
        $this->mostrarFormulario = false;            
        $insumo = Insumo::find($postId);

        $insumo->delete();

        $this->insumos = Insumo::all();
        $this->mostrarModalEliminacion = true;        
    }

    public $contador = 0;
    public $paginacion;
    
    public function incrementarPaginacion()
    {
        $this->paginacion = Paginacion::where('pagina', 'insumo')->first();
        $this->paginacion->increment('contador');
        //dd($this->paginacion);
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;

        //$this->incrementarPaginacion();
    }

    public function mount(){
        
        $this->insumos = Insumo::all();
        $this->categoriainsumos = CategoriaInsumo::all();
        $this->incrementarPaginacion();
        
    }

    public function render()
    {
        return view('livewire.formulario-insumo');
    }
}
