<?php

namespace App\Livewire;

use App\Models\Servicio;
use Livewire\Attributes\Rule;

use Livewire\Component;

class FormularioServicio extends Component
{
    /*
    #[Rule([
        'postCreate.title' => 'required',
        'postCreate.content' => 'required',                
        'postCreate.category_id' => 'required|exists:categories, id',
        'postCreate.tags' => 'required|array'
    ], [], [
        'postCreate.title' => 'titulo',
        'postCreate.content' => 'contenido',                
        'postCreate.category_id' => 'categoria',
        'postCreate.tags' => 'etiquetas'
    ])]
    */
    public $postCreate = [
        'nombre' => '',
        'descripcion' => '',
        'costo' => ''
    ];

    public $servicios;

    public $postEditId = '';

    public $open = false;

    public $postEdit = [
        'category_id' => '',
        'title' => '',
        'content' => '',
        'tags' => []
    ];

    public function rules()
    {
        return [
            'postCreate.nombre' => 'required',
            'postCreate.descripcion' => 'required',
            'postCreate.costo' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'postCreate.nombre.required' => 'El Campo nombre es requerido'
        ];
    }

    /*
    public function validationAttributes(){
        return [
            'postCreate.category_id' => 'categoria'
        ];
    }
    */

    public function mount()
    {
        //$this->categories = Category::all();
        //$this->tags = Tag::all();

        $this->servicios = Servicio::all();
    }

    public function save()
    {

        $this->validate();
        //Primera Forma
        /*
        $this->validate([            
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required|exists:categories, id',
            'selectedTags' => 'required|array'
        ], [
            'title.required' => 'El Campo titulo es requerido',
            
            // 'content' => 'required',
            // 'category_id' => 'required|exists:categories, id',
            // 'selectedTags' => 'required|array'
            
        ],[
            'category_id' => 'categoria'
        ]);
        */

        $servicio = Servicio::create([
            'nombre' => $this->postCreate['nombre'],
            'descripcion' => $this->postCreate['descripcion'],
            'costo' => $this->postCreate['costo']
        ]);

        //$post->tags()->attach($this->postCreate['tags']);

        $this->reset(['postCreate']);

        $this->servicios = Servicio::all();
    }

    public function edit($servicioID)
    {

        $this->open = true;

        $this->postEditId = $servicioID;

        $servicio = Servicio::find($servicioID);

        $this->postEdit['nombre'] = $servicio->nombre;
        $this->postEdit['descripcion'] = $servicio->descripcion;
        $this->postEdit['costo'] = $servicio->costo;
    }

    public function update()
    {

        $this->validate([
            'postEdit.nombre' => 'required',
            'postEdit.descripcion' => 'required',
            'postEdit.costo' => 'required',
        ]);


        $post = Servicio::find($this->postEditId);

        $post->update([
            'nombre' => $this->postEdit['nombre'],
            'descripcion' => $this->postEdit['descripcion'],
            'costo' => $this->postEdit['costo']
        ]);

        $this->reset(['postEditId', 'postEdit', 'open']);

        $this->servicios = Servicio::all();
    }

    public function destroy($servicioId)
    {
        $post = Servicio::find($servicioId);

        $post->delete();

        $this->servicios = Servicio::all();
    }
    public function render()
    {
        return view('livewire.formulario-servicio');
    }
}
