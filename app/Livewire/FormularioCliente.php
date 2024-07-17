<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Paginacion;
use App\Models\User;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class FormularioCliente extends Component
{

    public $clientes;
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
        
        'nit' => '',

        'email' => '',
        'password' => '',
        //'person_id' => '',        
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

        'nit' => '',
        //'person_id' => '',        

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
            'postCreate.nit' => 'required',     
            'postCreate.email' => 'required|email',
            'postCreate.password' => 'required|min:8',

        ];
    }

    public function messages()
    {
        //dd($this->getErrorBag());              
        //$this->mostrarModalFailCreacion = true; 
        //$this->mostrarModalFailEdit = true; 
        //dd($this->getErrorBag());              
        return [
            'postCreate.ci.required' => 'El Campo CI es requerido',
            'postCreate.nombre.required' => 'El Campo Nombre es requerido',
            'postCreate.apellidopaterno.required' => 'El Campo Apellido Paterno es requerido',
            'postCreate.apellidomaterno.required' => 'El Campo Apellido Materno es requerido',            
            'postCreate.sexo.required' => 'El Campo Sexo es requerido',
            'postCreate.telefono.required' => 'El Campo Telefono es requerido',
            'postCreate.direccion.required' => 'El Campo Direccion es requerido',            
            'postCreate.nit.required' => 'El Campo NIT es requerido',     
            'postCreate.email.required' => 'El Campo Email es requerido',
            'postCreate.password.required' => 'El Campo Password es requerido',


            'postEdit.ci.required' => 'El Campo CI es requerido',
            'postEdit.nombre.required' => 'El Campo Nombre es requerido',
            'postEdit.apellidopaterno.required' => 'El Campo Apellido Paterno es requerido',
            'postEdit.apellidomaterno.required' => 'El Campo Apellido Materno es requerido',            
            'postEdit.sexo.required' => 'El Campo Sexo es requerido',
            'postEdit.telefono.required' => 'El Campo Telefono es requerido',
            'postEdit.direccion.required' => 'El Campo Direccion es requerido',            
            'postEdit.nit.required' => 'El Campo NIT es requerido',     
            'postEdit.email.required' => 'El Campo Email es requerido',
            //'postEdit.password' => 'El Campo Password es requerido',
        ];
        
    }

    
    //ESTO SE USABA COMO EJEMPLO SI SE QUERIA CAMBIAR EL NOMBRE DE CATEGORY_ID a categoria
    public function validationAttributes(){
        return [
            'postCreate.email' => 'email',
            'postCreate.password' => 'password'
        ];
    }

    public function toggleCreateForm()
    {
        $this->resetValidation();
        $this->mostrarFormulario = !$this->mostrarFormulario;
    }

    public $contador = 0;
    public $paginacion;
    
    public function incrementarPaginacion()
    {
        $this->paginacion = Paginacion::where('pagina', 'cliente')->first();
        $this->paginacion->increment('contador');
        //dd($this->paginacion);
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;
    }

    public function mount()
    {
        $this->clientes = Cliente::all();
        $this->incrementarPaginacion();
    }

    public function save()
    {   
        /*     
        //Esto es en el caso QUERRAMOS REGLAS ESPECIFICAS
        $this->validate([
            'postCreate.nombre' => 'required',
            'postCreate.sexo' => 'required'
        ]);
        */        
        
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

        // Crear y guardar el cliente asociado a la persona
        $clienteCreated = Cliente::create([            
            'nit' => $this->postCreate['nit'],     
            'person_id' => $personaCreated->id, // Asignar el id de la persona creada       
        ]);
        
        // Crear y guardar el usuario asociado a la persona
        $userCreated = User::create([            
            'email' => $this->postCreate['email'],
            'password' => Hash::make($this->postCreate['password']),
            'person_id' => $personaCreated->id, // Asignar el id de la persona creada     
        ]);

        $userCreated->assignRole('Cliente');       
        

        $this->mostrarFormulario = false;        
        $this->reset(['postCreate']);
        $this->clientes = Cliente::all();
        
        $this->mostrarModalSucessCreacion = true;        
    }

    
    public function edit($postId){
        //RESETEA LOS ERRORES DE VALIDACION PARA EVITAR QUE DE UN CAMPO LE DAMOS A OTRO BOTON Y SIGUE EL ERROR
        $this->resetValidation();

        $this->mostrarFormulario = false;        
        $this->open = true;

        $this->postEditId = $postId;

        $clienteUpdate = Cliente::find($postId);
        $personId = $clienteUpdate->person_id;
        
        $userUpdate = User::where('person_id', $personId)->first();
        $personUpdate = Persona::find($personId);
        
        //dd($userUpdate);
        //dd($personUpdate);        

        $this->postEdit['nombre'] = $personUpdate->nombre;
        $this->postEdit['apellidopaterno'] = $personUpdate->apellidopaterno;        
        $this->postEdit['apellidomaterno'] = $personUpdate->apellidomaterno;
        $this->postEdit['sexo'] = $personUpdate->sexo;
        $this->postEdit['ci'] = $personUpdate->ci;
        $this->postEdit['telefono'] = $personUpdate->telefono;
        $this->postEdit['direccion'] = $personUpdate->direccion;
        
        $this->postEdit['email'] = $userUpdate->email;
        //$this->postEdit['password'] = $userUpdate->password;
        //$this->postEdit['password'] = $userCliente->password;
        $this->postEdit['nit'] = $clienteUpdate->nit;
        
    }

    
    public function update(){ 
        
        //$this->validate([
            //'postEdit.title' => 'required',
            //'postEdit.content' => 'required',                
            //'postEdit.category_id' => 'required|exists:categories, id',
            //'postEdit.tags' => 'required|array'
        //]);   
        
        $this->validate([
            'postEdit.ci' => 'required',
            'postEdit.nombre' => 'required',
            'postEdit.apellidopaterno' => 'required',
            'postEdit.apellidomaterno' => 'required',            
            'postEdit.sexo' => 'required',
            'postEdit.telefono' => 'required',
            'postEdit.direccion' => 'required',            
            'postEdit.nit' => 'required',     
            'postEdit.email' => 'required|email',
            //'postEdit.password' => 'required',
        ]);

        $clienteUpdate = Cliente::find($this->postEditId);
        $personId = $clienteUpdate->person_id;
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

        $clienteUpdate->update([
            'nit' => $this->postEdit['nit'],            
        ]);

        $this->mostrarFormulario = false;

        $this->reset(['postEditId', 'postEdit', 'open']);

        $this->clientes = Cliente::all();
        $this->mostrarModalSucessEdit = true;        
    }
    


    public function destroy($postId){       
        
        $clienteDelete = Cliente::find($postId);

        if (!$clienteDelete) {
            // Manejar el caso en que no se encuentra el cliente
            return;
        }
        // Obtener el id de la persona asociada al cliente
        $personId = $clienteDelete->person_id;
        // Encontrar el usuario que tiene el mismo person_id
        $userDelete = User::where('person_id', $personId)->first();
        $personDelete = Persona::find($personId);
        if ($userDelete) {
            // Eliminar el rol 'Cliente' al usuario (asumiendo que tienes un método `removeRole` definido en tu modelo User)
            $userDelete->removeRole('Cliente');
            // Eliminar el cliente
            $clienteDelete->delete();
            // Eliminar el usuario
            $userDelete->delete();
            // Eliminar a la persona
            $personDelete->delete();

            $this->mostrarFormulario = false;            
        }

        // Actualizar la lista de clientes después de la eliminación
        $this->clientes = Cliente::all();
        $this->mostrarModalEliminacion = true;        
    }

    public function render()
    {
        return view('livewire.formulario-cliente');
    }
}
