<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\CategoriaInsumo;
use App\Models\Paginacion;

class FormularioCategoriaInsumo extends Component
{
    public $categoriainsumos;

    public $mostrarFormulario = false;
    public $mostrarModalSucessCreacion = false;    
    //public $mostrarModalFailCreacion = false;    
    public $mostrarModalSucessEdit = false;    
    //public $mostrarModalFailEdit = false;    
    public $mostrarModalEliminacion = false;    

    
    public $postCreate = [        
        'nombre' => '',
        'descripcion' => ''        
    ];

    public $posts;

    public $postEditId = '';

    public $open = false;

    public $postEdit = [        
        'nombre' => '',
        'descripcion' => ''
    ];

    public function rules(){
        return [
            'postCreate.nombre' => 'required',
            'postCreate.descripcion' => 'required'
        ];
    }

    public function messages(){
        return [
            'postCreate.nombre.required' => 'El Campo Nombre es requerido',
            'postCreate.descripcion.required' => 'El Campo Descripcion es requerido',

            'postEdit.nombre.required' => 'El Campo Nombre es requerido',
            'postEdit.descripcion.required' => 'El Campo Descripcion es requerido'
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
        
        $categoriainsumo = CategoriaInsumo::create([
            'nombre' => $this->postCreate['nombre'],
            'descripcion' => $this->postCreate['descripcion']            
        ]);

        $this->mostrarFormulario = false;
        $this->reset(['postCreate']);
        $this->categoriainsumos = CategoriaInsumo::all();
        $this->mostrarModalSucessCreacion = true;        
    }

    public function edit($postId){
        $this->resetValidation();
        $this->mostrarFormulario = false;        
        $this->open = true;

        $this->postEditId = $postId;

        $categoriainsumo = CategoriaInsumo::find($postId);

        $this->postEdit['nombre'] = $categoriainsumo->nombre;
        $this->postEdit['descripcion'] = $categoriainsumo->descripcion;        
    }

    public function update(){ 
        /*         
        $this->validate([
            'postEdit.title' => 'required',
            'postEdit.content' => 'required',                
            'postEdit.category_id' => 'required|exists:categories, id',
            'postEdit.tags' => 'required|array'
        ]);
        */

        $this->validate([
            'postEdit.nombre' => 'required',
            'postEdit.descripcion' => 'required'
        ]);
        

        $categoriainsumo = CategoriaInsumo::find($this->postEditId);

        $categoriainsumo->update([
            'nombre' => $this->postEdit['nombre'],
            'descripcion' => $this->postEdit['descripcion']            
        ]);

        $this->mostrarFormulario = false;
        $this->reset(['postEditId', 'postEdit', 'open']);
        $this->categoriainsumos = CategoriaInsumo::all();
        $this->mostrarModalSucessEdit = true;        
    }

    public function destroy($postId){
        $this->mostrarFormulario = false;            
        $categoriainsumo = CategoriaInsumo::find($postId);

        $categoriainsumo->delete();

        $this->categoriainsumos = CategoriaInsumo::all();
        $this->mostrarModalEliminacion = true;        
    }

    public $contador = 0;
    public $paginacion;
    
    public function incrementarPaginacion()
    {
        $this->paginacion = Paginacion::where('pagina', 'categoriainsumo')->first();
        $this->paginacion->increment('contador');
        //dd($this->paginacion);
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;

        //$this->incrementarPaginacion();
    }

    public function mount(){
        
        $this->categoriainsumos = CategoriaInsumo::all();
        $this->incrementarPaginacion();
        
    }

    public function render()
    {
        return view('livewire.formulario-categoria-insumo');
    }
}
