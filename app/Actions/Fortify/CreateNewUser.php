<?php

namespace App\Actions\Fortify;

use App\Models\Persona;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        
        Validator::make($input, [
            //'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),  

            //'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',

            'nombre' => ['required', 'string', 'max:255'],
            'apellidopaterno' => ['required', 'string', 'max:255'],
            'apellidomaterno' => ['required', 'string', 'max:255'],
            'ci' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'sexo' => ['required', 'string', 'in:Masculino,Femenino'], // Asegúrate de ajustar los valores permitidos según tu caso

            'nit' => ['required', 'string', 'max:255'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
        
        
        $personaCreated = Persona::create([
            //'name' => $input['name'],
            
            //'email' => $input['email'],
            //'password' => Hash::make($input['password']),     
            'ci' => $input['ci'],
            'nombre' => $input['nombre'],
            'apellidopaterno' => $input['apellidopaterno'],
            'apellidomaterno' => $input['apellidomaterno'],
            'sexo' => $input['sexo'],
            'telefono' => $input['telefono'],
            'direccion' => $input['direccion'],
            
        ]);

        // Crear y guardar el cliente asociado a la persona
        $clienteCreated = Cliente::create([            
            'nit' => $input['nit'],     
            'person_id' => $personaCreated->id, // Asignar el id de la persona creada       
        ]);
        
        // Crear y guardar el usuario asociado a la persona
        $userCreated = User::create([            
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'person_id' => $personaCreated->id, // Asignar el id de la persona creada     
        ]);

        $userCreated->assignRole('Cliente');
        
        return $userCreated;
        /*
        $userCreated = User::create([
            //'name' => $input['name'],
            
            'email' => $input['email'],
            'password' => Hash::make($input['password']),     
            
            'apellidopaterno' => $input['apellidopaterno'],
            'apellidomaterno' => $input['apellidomaterno'],
            'ci' => $input['ci'],
            'telefono' => $input['telefono'],
            'direccion' => $input['direccion'],
            'sexo' => $input['sexo'],
        ]);
        */
        /*
        $userCreated->assignRole('Cliente');
        return $userCreated;
        */
        
        //$user->assignRole($roleProveedor);

        /*
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),            
        ]);
        */
        

        

        
    }
}
