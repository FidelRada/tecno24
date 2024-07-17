<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;

use App\Models\CategoriaInsumo;
use App\Models\Insumo;
use App\Models\Paginacion;
use App\Models\Persona;
use App\Models\TipoMovimiento;

class PermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        Permission::create(['name' => 'ver lista de posts']);
        $role1 = Role::create(['name' => 'pruebaposts']);
        $role1->givePermissionTo('ver lista de posts');
        */


        //$roleX = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        /*
        // create permissions
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'writer']);
        $role1->givePermissionTo('edit articles');
        $role1->givePermissionTo('delete articles');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('publish articles');
        $role2->givePermissionTo('unpublish articles');

        $role3 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider
*/

        // create demo users - Admin
        /*
        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
            'telefono' => '78458123',
        ]);
        $user->assignRole($roleX);
        */
        
        //Usuarios Iniciales:
        //Admin:
        $roleAdmin = Role::create(['name' => 'Super-Admin']);
        $roleCliente = Role::create(['name' => 'Cliente']);        
        $roleProveedor = Role::create(['name' => 'Proveedor']);        
        $roleGerente = Role::create(['name' => 'Gerente']);
        $roleAdministradorEmpresa = Role::create(['name' => 'AdministradorEmpresa']);
        
        //$roleArquitecto = Role::create(['name' => 'Arquitecto']);
        //$roleDiseñador = Role::create(['name' => 'Diseñador']);

        //CREACION DE UN ADMIN
        $personaCreated = Persona::create([                 
            'ci' => "0000000000",
            'nombre' => "Admin",
            'apellidopaterno' => "admin",
            'apellidomaterno' => "admin",
            'sexo' => "Masculino",
            'telefono' => "00000000",
            'direccion' => "En el espacio",
            
        ]);

        $user = \App\Models\User::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'), 
            'person_id' => $personaCreated->id           
        ]);
        //$user->removeRole('Cliente');        
        $user->assignRole($roleAdmin);


        //CREACION DE UN CLIENTE
        $personaCreated1 = Persona::create([                 
            'ci' => "9710072",
            'nombre' => "Erik",
            'apellidopaterno' => "Hurtado",
            'apellidomaterno' => "Gutierrez",
            'sexo' => "Masculino",
            'telefono' => "68574589",
            'direccion' => "C/ Los mangales 6to Anillo Av/Alemena",
            
        ]);

        $user1 = \App\Models\User::factory()->create([
            'email' => 'erik@test.com',
            'password' => Hash::make('12345678'), 
            'person_id' => $personaCreated1->id           
        ]);

        $cliente = \App\Models\Cliente::create([
            'nit' => '21245122115',
            'person_id' => $personaCreated1->id           
        ]);

        //$user->removeRole('Cliente');        
        $user1->assignRole($roleCliente);

        
        //CREACION DE UN PROVEEDOR
        $personaCreated2 = Persona::create([                 
            'ci' => "9898983",
            'nombre' => "Fidel",
            'apellidopaterno' => "Rada",
            'apellidomaterno' => "Rojas",
            'sexo' => "Masculino",
            'telefono' => "67865123",
            'direccion' => "C/ Los Virgen de Lujan 6to Anillo",
            
        ]);

        $user2 = \App\Models\User::factory()->create([
            'email' => 'fidel@test.com',
            'password' => Hash::make('12345678'), 
            'person_id' => $personaCreated2->id           
        ]);

        $proveedor = \App\Models\Proveedor::create([
            'nombreempresa' => 'Colorful SA',
            'cargoempresa' => 'Proveedor #21',
            'telefonoreferencia' => '76389234',

            'person_id' => $personaCreated2->id           
        ]);

        //$user->removeRole('Cliente');        
        $user2->assignRole($roleProveedor);

        //CREACION DE UN PERSONAL = Gerente
        $personaCreated3 = Persona::create([                 
            'ci' => "21323123",
            'nombre' => "Eliseo",
            'apellidopaterno' => "Perka",
            'apellidomaterno' => "Jimenez",
            'sexo' => "Masculino",
            'telefono' => "76523456",
            'direccion' => "C/ Bush 2do Anillo",
            
        ]);

        $user3 = \App\Models\User::factory()->create([
            'email' => 'eliseo@test.com',
            'password' => Hash::make('12345678'), 
            'person_id' => $personaCreated3->id           
        ]);

        $personal = \App\Models\Personal::create([
            'cargo' => 'Gerente Senior',                     

            'person_id' => $personaCreated3->id           
        ]);

        //$user->removeRole('Cliente');        
        $user3->assignRole($roleGerente);

        //CREACION DE UN PERSONAL = AdministradorEmpresa
        $personaCreated4 = Persona::create([                 
            'ci' => "8923232",
            'nombre' => "Fernando",
            'apellidopaterno' => "Martinez",
            'apellidomaterno' => "Gutierrez",
            'sexo' => "Masculino",
            'telefono' => "69812344",
            'direccion' => "C/ La ramada 2do anillo",
            
        ]);

        $user4 = \App\Models\User::factory()->create([
            'email' => 'fernando@test.com',
            'password' => Hash::make('12345678'), 
            'person_id' => $personaCreated4->id           
        ]);

        $personal = \App\Models\Personal::create([
            'cargo' => 'Administrador de la Empresa',                     

            'person_id' => $personaCreated4->id           
        ]);

        //$user->removeRole('Cliente');        
        $user4->assignRole($roleAdministradorEmpresa);

        


        

        


        //Lista de Permisos:

        //Acceso a pestañas
        
        //Gestion de Usuarios
        Permission::create(['name' => 'Visualizar pestaña de Gestion de Usuarios']);
        Permission::create(['name' => 'Visualizar pestaña de Gestion de Clientes']);
        Permission::create(['name' => 'Visualizar pestaña de Gestion de Proveedores']);
        Permission::create(['name' => 'Visualizar pestaña de Gestion de Personal']);
        Permission::create(['name' => 'Visualizar pestaña de Gestion de Roles']);

        //Gestion de Insumos
        Permission::create(['name' => 'Ver pestaña de Gestion de Insumos']);
        Permission::create(['name' => 'Ver pestaña de Categoria de Insumos']);
        Permission::create(['name' => 'Ver pestaña de Insumos']);

        //Gestion de Inventarios
        Permission::create(['name' => 'Ver pestaña de Gestion de Inventarios']);
        Permission::create(['name' => 'Ver pestaña de Movimientos']);

        //Gestion de Pedidos
        Permission::create(['name' => 'Ver pestaña de Gestion de Pedidos']);
        Permission::create(['name' => 'Ver pestaña de Mis Pedidos']);
        Permission::create(['name' => 'Ver pestaña de Cotizaciones']);
        
        /*
        //Gestion de Pagos
        Permission::create(['name' => 'Ver pestaña de Gestion de Pagos']);
        Permission::create(['name' => 'Ver pestaña de Pedidos Pagados']);
        */
        
        //Usuarios->Cliente, Proveedor, Personal, Roles----------------------------------------------------
        
        //Listar
        Permission::create(['name' => 'Ver Lista de Clientes']);
        Permission::create(['name' => 'Ver Lista de Proveedores']);
        Permission::create(['name' => 'Ver Lista de Personal']);
        Permission::create(['name' => 'Ver Lista de Roles']);
        Permission::create(['name' => 'Ver Lista de Permisos del Rol']);

        //Anadir
        Permission::create(['name' => 'Añadir un Nuevo Cliente']);        
        Permission::create(['name' => 'Añadir un Nuevo Proveedor']);
        Permission::create(['name' => 'Añadir un Nuevo Personal']);
        Permission::create(['name' => 'Añadir un Nuevo Rol y sus Permisos']);

        //Editar
        Permission::create(['name' => 'Editar Cliente']);
        Permission::create(['name' => 'Editar Proveedor']);
        Permission::create(['name' => 'Editar Personal']);
        Permission::create(['name' => 'Editar Rol y sus Permisos']);
        
        //Eliminar
        Permission::create(['name' => 'Eliminar Cliente']);
        Permission::create(['name' => 'Eliminar Proveedor']);
        Permission::create(['name' => 'Eliminar Personal']);
        Permission::create(['name' => 'Eliminar Rol y sus Permisos']);
        
        //Insumos->Categoria de Insumos, Insumos----------------------------------------------------------

        //Listar
        Permission::create(['name' => 'Ver Lista de Categorias de Insumos']);
        Permission::create(['name' => 'Ver Lista de Insumos']);

        //Anadir
        Permission::create(['name' => 'Añadir una Nueva Categoria de Insumo']);
        Permission::create(['name' => 'Añadir un Nuevo Insumo']);

        //Editar    
        Permission::create(['name' => 'Editar una Categoria de Insumo']);
        Permission::create(['name' => 'Editar un Insumo']);

        //Eliminar
        Permission::create(['name' => 'Eliminar una Categoria de Insumo']);
        Permission::create(['name' => 'Eliminar un Insumo']);

        //Inventarios->Movimientos-----------------------------------------------------------------

        //Listar
        Permission::create(['name' => 'Ver Lista de movimientos']);
        Permission::create(['name' => 'Ver Informacion del movimiento']);        
        
        //Anadir
        Permission::create(['name' => 'Añadir un Nuevo Movimiento']);
        
        //Conseguir
        Permission::create(['name' => 'Ver informacion de un Movimiento']);

        //Pedidos-> Mis Pedidos, Cotizaciones------------------------------------------------------
        //Listar
        Permission::create(['name' => 'Ver Lista de Pedidos']);
        Permission::create(['name' => 'Ver Lista de Cotizaciones']);

        //Anadir
        Permission::create(['name' => 'Añadir un Nuevo Pedido']);
        Permission::create(['name' => 'Añadir una Nueva Cotizacion']);

        //Eliminar
        Permission::create(['name' => 'Eliminar un Pedido']);

        //Solicitar Cotizacion(Ver Detalle Pedido)
        Permission::create(['name' => 'Solicitar una cotizacion para un pedido']);
        
        //Enviar una Cotizacion
        Permission::create(['name' => 'Enviar una cotizacion de un pedido al cliente']);

        //Ver cotizacion de un pedido
        Permission::create(['name' => 'Ver cotizacion recibida']);
        
        /*
        //Pagos ->TBD<-
        Permission::create(['name' => 'ver lista de metodos de pago']);
        Permission::create(['name' => 'añadir un nuevo metodo de pago']);
        Permission::create(['name' => 'editar un metodo de pago']);
        Permission::create(['name' => 'eliminar un metodo de pago']);


        //Reportes y Estadisticas ->TBD<-

        */

        //Roles Asignados al Cliente

        $roleCliente->givePermissionTo('Ver pestaña de Gestion de Pedidos'); 
        $roleCliente->givePermissionTo('Ver pestaña de Mis Pedidos'); 
        $roleCliente->givePermissionTo('Ver Lista de Pedidos'); 
        $roleCliente->givePermissionTo('Añadir un Nuevo Pedido'); 
        $roleCliente->givePermissionTo('Eliminar un Pedido'); 
        $roleCliente->givePermissionTo('Solicitar una cotizacion para un pedido'); 
        $roleCliente->givePermissionTo('Ver cotizacion recibida'); 
        
        

        


        //Roles Asignados al Proveedor

        $roleProveedor->givePermissionTo('Ver pestaña de Gestion de Inventarios'); 

        //Roles Asignados al Gerente

        $roleGerente->givePermissionTo('Visualizar pestaña de Gestion de Usuarios');
        $roleGerente->givePermissionTo('Visualizar pestaña de Gestion de Clientes'); 
        $roleGerente->givePermissionTo('Visualizar pestaña de Gestion de Proveedores'); 
        $roleGerente->givePermissionTo('Visualizar pestaña de Gestion de Personal'); 
        $roleGerente->givePermissionTo('Visualizar pestaña de Gestion de Roles'); 
        $roleGerente->givePermissionTo('Ver pestaña de Gestion de Insumos'); 
        $roleGerente->givePermissionTo('Ver pestaña de Categoria de Insumos'); 
        $roleGerente->givePermissionTo('Ver pestaña de Insumos'); 
        $roleGerente->givePermissionTo('Ver pestaña de Gestion de Inventarios'); 
        $roleGerente->givePermissionTo('Ver pestaña de Movimientos'); 
        $roleGerente->givePermissionTo('Ver pestaña de Gestion de Pedidos'); 
        $roleGerente->givePermissionTo('Ver pestaña de Mis Pedidos'); 
        $roleGerente->givePermissionTo('Ver pestaña de Cotizaciones'); 

        $roleGerente->givePermissionTo('Ver Lista de Clientes');
        $roleGerente->givePermissionTo('Ver Lista de Proveedores');
        $roleGerente->givePermissionTo('Ver Lista de Personal');
        $roleGerente->givePermissionTo('Ver Lista de Roles');
        $roleGerente->givePermissionTo('Ver Lista de Permisos del Rol');
        

        $roleGerente->givePermissionTo('Añadir un Nuevo Cliente');
        $roleGerente->givePermissionTo('Añadir un Nuevo Proveedor');
        $roleGerente->givePermissionTo('Añadir un Nuevo Personal');
        $roleGerente->givePermissionTo('Añadir un Nuevo Rol y sus Permisos');

        $roleGerente->givePermissionTo('Editar Cliente');
        $roleGerente->givePermissionTo('Editar Proveedor');
        $roleGerente->givePermissionTo('Editar Personal');
        $roleGerente->givePermissionTo('Editar Rol y sus Permisos');

        $roleGerente->givePermissionTo('Eliminar Cliente');
        $roleGerente->givePermissionTo('Eliminar Proveedor');
        $roleGerente->givePermissionTo('Eliminar Personal');
        $roleGerente->givePermissionTo('Eliminar Rol y sus Permisos');

        $roleGerente->givePermissionTo('Ver Lista de Categorias de Insumos');
        $roleGerente->givePermissionTo('Ver Lista de Insumos');

        $roleGerente->givePermissionTo('Añadir una Nueva Categoria de Insumo');
        $roleGerente->givePermissionTo('Añadir un Nuevo Insumo');

        $roleGerente->givePermissionTo('Editar una Categoria de Insumo');
        $roleGerente->givePermissionTo('Editar un Insumo');

        $roleGerente->givePermissionTo('Ver Lista de movimientos');
        $roleGerente->givePermissionTo('Ver Informacion del movimiento');

        

        $roleGerente->givePermissionTo('Añadir un Nuevo Movimiento');

        

        $roleGerente->givePermissionTo('Ver Lista de Pedidos');
        $roleGerente->givePermissionTo('Ver Lista de Cotizaciones');

        $roleGerente->givePermissionTo('Añadir un Nuevo Pedido');
        $roleGerente->givePermissionTo('Añadir una Nueva Cotizacion');

        $roleGerente->givePermissionTo('Eliminar un Pedido');

        $roleGerente->givePermissionTo('Solicitar una cotizacion para un pedido');

        $roleGerente->givePermissionTo('Enviar una cotizacion de un pedido al cliente');

        $roleGerente->givePermissionTo('Ver cotizacion recibida');


        //Roles Asignados al Administrador de la Empresa

        $roleAdministradorEmpresa->givePermissionTo('Visualizar pestaña de Gestion de Usuarios');
        $roleAdministradorEmpresa->givePermissionTo('Visualizar pestaña de Gestion de Clientes'); 
        $roleAdministradorEmpresa->givePermissionTo('Visualizar pestaña de Gestion de Proveedores'); 
        $roleAdministradorEmpresa->givePermissionTo('Visualizar pestaña de Gestion de Personal'); 
        $roleAdministradorEmpresa->givePermissionTo('Visualizar pestaña de Gestion de Roles'); 
        $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Gestion de Insumos'); 
        $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Categoria de Insumos'); 
        $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Insumos'); 
        $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Gestion de Inventarios'); 
        $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Movimientos'); 
        $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Gestion de Pedidos'); 
        $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Mis Pedidos'); 
        $roleAdministradorEmpresa->givePermissionTo('Ver pestaña de Cotizaciones'); 
        
        $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Clientes');
        $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Proveedores');
        $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Personal');
        $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Roles');
        $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Permisos del Rol');

        $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Cliente');
        $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Proveedor');
        $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Personal');
        $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Rol y sus Permisos');

        $roleAdministradorEmpresa->givePermissionTo('Editar Cliente');
        $roleAdministradorEmpresa->givePermissionTo('Editar Proveedor');
        $roleAdministradorEmpresa->givePermissionTo('Editar Personal');
        $roleAdministradorEmpresa->givePermissionTo('Editar Rol y sus Permisos');

        $roleAdministradorEmpresa->givePermissionTo('Eliminar Cliente');
        $roleAdministradorEmpresa->givePermissionTo('Eliminar Proveedor');
        $roleAdministradorEmpresa->givePermissionTo('Eliminar Personal');
        $roleAdministradorEmpresa->givePermissionTo('Eliminar Rol y sus Permisos');

        $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Categorias de Insumos');
        $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Insumos');

        $roleAdministradorEmpresa->givePermissionTo('Añadir una Nueva Categoria de Insumo');
        $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Insumo');

        $roleAdministradorEmpresa->givePermissionTo('Editar una Categoria de Insumo');
        $roleAdministradorEmpresa->givePermissionTo('Editar un Insumo');

        $roleAdministradorEmpresa->givePermissionTo('Ver Lista de movimientos');
        $roleAdministradorEmpresa->givePermissionTo('Ver Informacion del movimiento');

        $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Movimiento');

        

        $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Pedidos');
        $roleAdministradorEmpresa->givePermissionTo('Ver Lista de Cotizaciones');

        $roleAdministradorEmpresa->givePermissionTo('Añadir un Nuevo Pedido');
        $roleAdministradorEmpresa->givePermissionTo('Añadir una Nueva Cotizacion');

        $roleAdministradorEmpresa->givePermissionTo('Eliminar un Pedido');

        $roleAdministradorEmpresa->givePermissionTo('Solicitar una cotizacion para un pedido');

        $roleAdministradorEmpresa->givePermissionTo('Enviar una cotizacion de un pedido al cliente');

        $roleAdministradorEmpresa->givePermissionTo('Ver cotizacion recibida');
        
        

        // Seeders de cosas utiles para probar--------------------

        $categoriainsumo1 = CategoriaInsumo::create([
            'nombre' => 'Tintas para Impresion',
            'descripcion' => 'Descripcion de Tintas de Impresion',
        ]);

        $categoriainsumo2 = CategoriaInsumo::create([
            'nombre' => 'Lonas',
            'descripcion' => 'Descripcion de Lonas',
        ]);

        $insumo = Insumo::create([
            'nombre' => 'Tinta Premium',
            'marca' => 'Colorful',
            'origen' => 'USA',
            'categoria_insumo_id' => $categoriainsumo1->id,
        ]);

        $tipomovimiento1 = TipoMovimiento::create([
            'nombre' => 'ingreso',
            'descripcion' => 'Movimiento para denotar los ingresos de materiales',
        ]);

        $tipomovimiento2 = TipoMovimiento::create([
            'nombre' => 'egreso',
            'descripcion' => 'Movimiento para denotar los egresos de materiales',
        ]);
        
        //Paginacion-------------------------------------------------

        Paginacion::create([            
            'pagina' => 'cliente',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'proveedor',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'personal',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'roles',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'categoriainsumo',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'insumo',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'movimiento',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'pedido',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'cotizacion',
            'contador' => 0,
        ]);

        Paginacion::create([            
            'pagina' => 'pago',
            'contador' => 0,
        ]);



        //Run Migrations

        //php artisan migrate:fresh --seed --seeder=PermissionsSeeder

        //Comando para ejectutar ngrok
        //ngrok config add-authtoken 2jFtrIoioGX8QxJKIRvsgj5ne4v_5PP6jv1BAbsaGMVqjkCqW
        //ngrok http http://localhost:8000

    }
}
