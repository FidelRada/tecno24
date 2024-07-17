<?php

namespace App\Livewire;

use App\Models\Paginacion;
use App\Models\Personal;
use App\Models\User;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class FormularioPersonal extends Component
{
    public $personals;
    public $roles;
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
        
        'cargo' => '',
        'rolpersonal'=> '',

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

        'cargo' => '',
        'rolpersonal'=> '',
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
            'postCreate.email' => 'required|email',
            'postCreate.password' => 'required|min:8',
            'postCreate.cargo' => 'required',     
            'postCreate.rolpersonal' => 'required',               
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
            'postCreate.cargo.required' => 'El Campo Cargo en la Empresa es requerido',     
            'postCreate.rolpersonal.required' => 'El Campo Rol de la Empresa es requerido',   
            


            'postEdit.ci.required' => 'El Campo CI es requerido',
            'postEdit.nombre.required' => 'El Campo Nombre es requerido',
            'postEdit.apellidopaterno.required' => 'El Campo Apellido Paterno es requerido',
            'postEdit.apellidomaterno.required' => 'El Campo Apellido Materno es requerido',            
            'postEdit.sexo.required' => 'El Campo Sexo es requerido',
            'postEdit.telefono.required' => 'El Campo Telefono es requerido',
            'postEdit.direccion.required' => 'El Campo Direccion es requerido',                        
            'postEdit.email.required' => 'El Campo Email es requerido',            
            'postEdit.cargo.required' => 'El Campo Cargo en la Empresa es requerido',   
            'postEdit.rolpersonal.required' => 'El Campo Rol de la Empresa es requerido',     
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
        $this->paginacion = Paginacion::where('pagina', 'personal')->first();
        $this->paginacion->increment('contador');
        //dd($this->paginacion);
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;

        //$this->incrementarPaginacion();
    }

    public function mount()
    {

        $this->personals = Personal::all();
        //$this->roles = Role::all();

        // Obtener todos los roles
        $allRoles = Role::all();
        // Roles que deseas excluir del select
        $rolesExcluidos = ['Super-Admin', 'Cliente', 'Proveedor', 'Empleado'];
        // Filtrar los roles excluidos
        $this->roles = $allRoles->reject(function ($role) use ($rolesExcluidos) {
            return in_array($role->name, $rolesExcluidos);
        });
        $this->incrementarPaginacion();
    }

    public function save()
    {   
        $this->validate();        
        //dd($this->postCreate['rolpersonal']);
        $personaCreated = Persona::create([
            'ci' => $this->postCreate['ci'],
            'nombre' => $this->postCreate['nombre'],
            'apellidopaterno' => $this->postCreate['apellidopaterno'],
            'apellidomaterno' => $this->postCreate['apellidomaterno'],            
            'sexo' => $this->postCreate['sexo'],            
            'telefono' => $this->postCreate['telefono'],
            'direccion' => $this->postCreate['direccion'],            
            
        ]);

        // Crear y guardar el personal asociado a la persona
        $personalCreated = Personal::create([            
            'cargo' => $this->postCreate['cargo'],     
            'person_id' => $personaCreated->id, // Asignar el id de la persona creada       
        ]);
        
        // Crear y guardar el usuario asociado a la persona
        $userCreated = User::create([            
            'email' => $this->postCreate['email'],
            'password' => Hash::make($this->postCreate['password']),
            'person_id' => $personaCreated->id, // Asignar el id de la persona creada     
        ]);

        $userCreated->assignRole($this->postCreate['rolpersonal']);
        
        $this->mostrarFormulario = false;
        $this->reset(['postCreate']);
        $this->personals = Personal::all();

        $this->mostrarModalSucessCreacion = true;        
    }

    
    public function edit($postId){
        $this->resetValidation();
        $this->open = true;

        $this->postEditId = $postId;

        $personalUpdate = Personal::find($postId);
        $personId = $personalUpdate->person_id;
        
        $userUpdate = User::where('person_id', $personId)->first();
        $personUpdate = Persona::find($personId);

        $roleUpdate = $userUpdate->roles()->first()->name;
        //dd($roleUpdate);
        
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
        $this->postEdit['cargo'] = $personalUpdate->cargo;
        
        $this->postEdit['rolpersonal'] = $roleUpdate;
        
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
            'postEdit.cargo' => 'required',     
            'postEdit.rolpersonal' => 'required',     
            //'postEdit.password' => 'required',
        ]); 
        
        /*
        $cliente = Cliente::find($this->postEditId);
        $userCliente = User::find($cliente->user_id);
        */

        $personalUpdate = Personal::find($this->postEditId);
        $personId = $personalUpdate->person_id;

        //dd($personalUpdate);
        
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

        $personalUpdate->update([
            'cargo' => $this->postEdit['cargo'],            
        ]);

        $userUpdate->syncRoles([]);
        $userUpdate->assignRole($this->postEdit['rolpersonal']);  
        
        $this->mostrarFormulario = false;

        $this->reset(['postEditId', 'postEdit', 'open']);

        $this->personals = Personal::all();
        $this->mostrarModalSucessEdit = true;        
    }
    


    public function destroy($postId){       
        $personalDelete = Personal::find($postId);

        if (!$personalDelete) {
            // Manejar el caso en que no se encuentra el cliente
            return;
        }
        // Obtener el id de la persona asociada al cliente
        $personId = $personalDelete->person_id;
        // Encontrar el usuario que tiene el mismo person_id
        $userDelete = User::where('person_id', $personId)->first();
        $personDelete = Persona::find($personId);
        
        $roleDelete = $userDelete->roles()->first()->name;

        if ($userDelete) {

            // Eliminar el rol 'Cliente' al usuario (asumiendo que tienes un método `removeRole` definido en tu modelo User)
            $userDelete->removeRole($roleDelete);
            // Eliminar el cliente
            $personalDelete->delete();
            // Eliminar el usuario
            $userDelete->delete();
            // Eliminar a la persona
            $personDelete->delete();

            $this->mostrarFormulario = false;
        }

        // Actualizar la lista de clientes después de la eliminación
        $this->personals = Personal::all();
        $this->mostrarModalEliminacion = true;        
    }




    public function render()
    {
        return view('livewire.formulario-personal');
    }
}
