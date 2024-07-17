<?php

namespace App\Livewire;

use App\Models\Paginacion;
use App\Models\Proveedor;
use App\Models\User;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class FormularioProveedor extends Component
{
    public $proveedors;
    public $mostrarFormulario = false;

    public $mostrarModalSucessCreacion = false;    
    //public $mostrarModalFailCreacion = false;    
    public $mostrarModalSucessEdit = false;    
    //public $mostrarModalFailEdit = false;    
    public $mostrarModalEliminacion = false;    


    public $postCreate = [
        'user_id' => '',
        'nombre' => '',
        'apellidopaterno' => '',
        'apellidomaterno' => '',
        'sexo' => '',
        'ci' => '',
        'telefono' => '',
        'direccion' => '',
        
        'nombreempresa' => '',
        'cargoempresa' => '',
        'telefonoreferencia' => '',

        'email' => '',
        'password' => '',
    ];

    public $posts;

    public $postEditId = '';

    public $open = false;

    public $postEdit = [
        'user_id' => '',
        'nombre' => '',
        'apellidopaterno' => '',
        'apellidomaterno' => '',
        'sexo' => '',
        'ci' => '',
        'telefono' => '',
        'direccion' => '',
        
        'nombreempresa' => '',
        'cargoempresa' => '',
        'telefonoreferencia' => '',

        'email' => '',
        //'password' => '',
    ];

    public function rules()
    {
        return [
            'postCreate.ci' => 'required',
            'postCreate.nombre' => 'required',
            'postCreate.apellidopaterno' => 'required',
            'postCreate.apellidomaterno' => 'required',            
            'postCreate.sexo' => 'required',
            'postCreate.telefono' => 'required',
            'postCreate.direccion' => 'required',                        
            'postCreate.email' => 'required|email',
            'postCreate.password' => 'required|min:8',
            'postCreate.nombreempresa' => 'required',     
            'postCreate.cargoempresa' => 'required',   
            'postCreate.telefonoreferencia' => 'required',     
        ];
    }

    public function messages()
    {
        return [
            'postCreate.ci.required' => 'El Campo CI es requerido',
            'postCreate.nombre.required' => 'El Campo Nombre es requerido',
            'postCreate.apellidopaterno.required' => 'El Campo Apellido Paterno es requerido',
            'postCreate.apellidomaterno.required' => 'El Campo Apellido Materno es requerido',            
            'postCreate.sexo.required' => 'El Campo Sexo es requerido',
            'postCreate.telefono.required' => 'El Campo Telefono es requerido',
            'postCreate.direccion.required' => 'El Campo Direccion es requerido',                        
            'postCreate.email.required' => 'El Campo Email es requerido',
            'postCreate.password.required' => 'El Campo Password es requerido',
            'postCreate.nombreempresa.required' => 'El Campo Nombre de la Empresa es requerido',     
            'postCreate.cargoempresa.required' => 'El Campo Cargo en la Empresa es requerido',   
            'postCreate.telefonoreferencia.required' => 'El Campo Telefono de Referencia es requerido',     


            'postEdit.ci.required' => 'El Campo CI es requerido',
            'postEdit.nombre.required' => 'El Campo Nombre es requerido',
            'postEdit.apellidopaterno.required' => 'El Campo Apellido Paterno es requerido',
            'postEdit.apellidomaterno.required' => 'El Campo Apellido Materno es requerido',            
            'postEdit.sexo.required' => 'El Campo Sexo es requerido',
            'postEdit.telefono.required' => 'El Campo Telefono es requerido',
            'postEdit.direccion.required' => 'El Campo Direccion es requerido',                        
            'postEdit.email.required' => 'El Campo Email es requerido',
            'postEdit.nombreempresa.required' => 'El Campo Nombre de la Empresa es requerido',     
            'postEdit.cargoempresa.required' => 'El Campo Cargo en la Empresa es requerido',   
            'postEdit.telefonoreferencia.required' => 'El Campo Telefono de Referencia es requerido',     
        ];
    }

    
    public function validationAttributes(){
        return [
            'postCreate.email' => 'email',
            'postCreate.password' => 'password'
        ];
    }
    

    public function toggleCreateForm()
    {
        $this->mostrarFormulario = !$this->mostrarFormulario;
    }

    public $contador = 0;
    public $paginacion;
    
    public function incrementarPaginacion()
    {
        $this->paginacion = Paginacion::where('pagina', 'proveedor')->first();
        $this->paginacion->increment('contador');
        //dd($this->paginacion);
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;
    }


    public function mount()
    {

        $this->proveedors = Proveedor::all();
        $this->incrementarPaginacion();
    }

    public function save()
    {
        $this->validate();        
        $personaCreated = Persona::create([
            'ci' => $this->postCreate['ci'],
            'nombre' => $this->postCreate['nombre'],
            'apellidopaterno' => $this->postCreate['apellidopaterno'],
            'apellidomaterno' => $this->postCreate['apellidomaterno'],            
            'sexo' => $this->postCreate['sexo'],            
            'telefono' => $this->postCreate['telefono'],
            'direccion' => $this->postCreate['direccion'],            
            
        ]);

        $proveedorCreated = Proveedor::create([
            'nombreempresa' => $this->postCreate['nombreempresa'],
            'cargoempresa' => $this->postCreate['cargoempresa'],
            'telefonoreferencia' => $this->postCreate['telefonoreferencia'],
            'person_id' => $personaCreated->id, // Asignar el id de la persona creada       
        ]);        

        // Crear y guardar el usuario asociado a la persona
        $userCreated = User::create([            
            'email' => $this->postCreate['email'],
            'password' => Hash::make($this->postCreate['password']),
            'person_id' => $personaCreated->id, // Asignar el id de la persona creada     
        ]);

        $userCreated->assignRole('Proveedor');        

        //return $userCreated;

        $this->mostrarFormulario = false;
        
        $this->reset(['postCreate']);

        $this->proveedors = Proveedor::all();

        $this->mostrarModalSucessCreacion = true;        
    }

    
    public function edit($postId){
        $this->resetValidation();
        $this->open = true;

        $this->postEditId = $postId;

        $proveedorUpdate = Proveedor::find($postId);
        $personId = $proveedorUpdate->person_id;
        
        $userUpdate = User::where('person_id', $personId)->first();
        $personUpdate = Persona::find($personId);

        $this->postEdit['nombre'] = $personUpdate->nombre;
        $this->postEdit['apellidopaterno'] = $personUpdate->apellidopaterno;        
        $this->postEdit['apellidomaterno'] = $personUpdate->apellidomaterno;
        $this->postEdit['sexo'] = $personUpdate->sexo;
        $this->postEdit['ci'] = $personUpdate->ci;
        $this->postEdit['telefono'] = $personUpdate->telefono;
        $this->postEdit['direccion'] = $personUpdate->direccion;
        //$this->postEdit['password'] = $userCliente->password;

        $this->postEdit['email'] = $userUpdate->email;

        $this->postEdit['nombreempresa'] = $proveedorUpdate->nombreempresa;
        $this->postEdit['cargoempresa'] = $proveedorUpdate->cargoempresa;
        $this->postEdit['telefonoreferencia'] = $proveedorUpdate->telefonoreferencia;
    }

    
    public function update(){ 
        
        $this->validate([
            'postEdit.ci' => 'required',
            'postEdit.nombre' => 'required',
            'postEdit.apellidopaterno' => 'required',
            'postEdit.apellidomaterno' => 'required',            
            'postEdit.sexo' => 'required',
            'postEdit.telefono' => 'required',
            'postEdit.direccion' => 'required',                        
            'postEdit.email' => 'required|email',
            'postEdit.nombreempresa' => 'required',     
            'postEdit.cargoempresa' => 'required',   
            'postEdit.telefonoreferencia' => 'required',     
            //'postEdit.password' => 'required',
        ]);

        $proveedorUpdate = Proveedor::find($this->postEditId);
        $personId = $proveedorUpdate->person_id;

        //dd($clienteUpdate);
        
        $userUpdate = User::where('person_id', $personId)->first();
        //dd($userUpdate);

        $personUpdate = Persona::find($personId);
        //dd($personUpdate); 
        
        $personUpdate->update([
            'ci' => $this->postEdit['ci'],
            'nombre' => $this->postEdit['nombre'],
            'apellidopaterno' => $this->postEdit['apellidopaterno'],
            'apellidomaterno' => $this->postEdit['apellidomaterno'],            
            'sexo' => $this->postEdit['sexo'],            
            'telefono' => $this->postEdit['telefono'],
            'direccion' => $this->postEdit['direccion'], 
        ]);
        
        $userUpdate->update([            
            'email' => $this->postEdit['email'],            
            //'password' => $this->postEdit['password'],            
        ]);

        $proveedorUpdate->update([
            'nombreempresa' => $this->postEdit['nombreempresa'],
            'cargoempresa' => $this->postEdit['cargoempresa'],
            'telefonoreferencia' => $this->postEdit['telefonoreferencia'],
        ]);

        $this->mostrarFormulario = false;

        $this->reset(['postEditId', 'postEdit', 'open']);

        $this->proveedors = Proveedor::all();
        $this->mostrarModalSucessEdit = true;        
    }
    


    public function destroy($postId){
        $proveedorDelete = Proveedor::find($postId);

        if (!$proveedorDelete) {
            // Manejar el caso en que no se encuentra el proveedor
            return;
        }
        // Obtener el id de la persona asociada al proveedor
        $personId = $proveedorDelete->person_id;
        // Encontrar el usuario que tiene el mismo person_id
        $userDelete = User::where('person_id', $personId)->first();
        $personDelete = Persona::find($personId);
        if ($userDelete) {
            // Eliminar el rol 'Proveedor' al usuario (asumiendo que tienes un método `removeRole` definido en tu modelo User)
            $userDelete->removeRole('Proveedor');
            // Eliminar el proveedor
            $proveedorDelete->delete();
            // Eliminar el usuario
            $userDelete->delete();
            // Eliminar a la persona
            $personDelete->delete();

            $this->mostrarFormulario = false;
        }

    // Actualizar la lista de proveedors después de la eliminación
    
        

        $this->proveedors = Proveedor::all();
        $this->mostrarModalEliminacion = true;        
    }

    public function render()
    {
        return view('livewire.formulario-proveedor');
    }
}
