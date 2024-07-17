<div>
    @can('Añadir un Nuevo Proveedor')
        <div class="flex justify mb-4">
            <x-button wire:click="toggleCreateForm">
                +
            </x-button>
        </div>
        @if ($mostrarFormulario)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
                <form wire:submit="save">
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Nombre
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.nombre" />
                        <x-input-error for="postCreate.nombre" />
                    </div>
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Apellido Paterno
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.apellidopaterno" />
                        <x-input-error for="postCreate.apellidopaterno" />
                    </div>
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Apellido Materno
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.apellidomaterno" />
                        <x-input-error for="postCreate.apellidomaterno" />
                    </div>
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Sexo
                        </x-label>
                        <select class="w-full font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.sexo">
                            <option value="">Seleccione una opcion</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                        <x-input-error for="postCreate.sexo" />
                    </div>
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Carnet de Identidad
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.ci" />
                        <x-input-error for="postCreate.ci" />
                    </div>
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Telefono
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.telefono" />
                        <x-input-error for="postCreate.telefono" />
                    </div>
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Direccion
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.direccion" />
                        <x-input-error for="postCreate.direccion" />
                    </div>

                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Correo Electronico
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.email" />
                        <x-input-error for="postCreate.email" />
                    </div>

                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Password
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            type="password" wire:model="postCreate.password" />
                        <x-input-error for="postCreate.password" />
                    </div>

                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Nombre de la Empresa
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.nombreempresa" />
                        <x-input-error for="postCreate.nombreempresa" />
                    </div>

                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Cargo del Proveedor en la Empresa
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.cargoempresa" />
                        <x-input-error for="postCreate.cargoempresa" />
                    </div>

                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Telefono de Referencia
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.telefonoreferencia" />
                        <x-input-error for="postCreate.telefonoreferencia" />
                    </div>
                    <div class="flex justify-end">
                        <x-button>
                            Crear
                        </x-button>
                    </div>
                </form>
            </div>
        @endif
    @endcan

    @can('Ver Lista de Proveedores')
        <!--Formulario para ver los posts creados / En este se aplicara el can-->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="overflow-x-auto">
                <div class="min-w-full overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr class="font-semibold text-sm text-gray-700 dark:text-gray-200">
                                <th scope="col" class="px-6 py-3 text-left">ID</th>
                                <th scope="col" class="px-6 py-3 text-left">Nombre</th>
                                <th scope="col" class="px-6 py-3 text-left">CI</th>
                                <th scope="col" class="px-6 py-3 text-left">Teléfono</th>
                                <th scope="col" class="px-6 py-3 text-left">Empresa</th>
                                <th scope="col" class="px-6 py-3 text-left">Cargo</th>

                                <th scope="col" class="px-6 py-3 text-left">Opciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($proveedors as $proveedor)
                                <tr class="text-sm text-gray-700 dark:text-gray-200">
                                    <td class="px-6 py-4">{{ $proveedor->persona->id }}</td>
                                    <td class="px-6 py-4">{{ $proveedor->persona->nombre }} {{ $proveedor->persona->apellidopaterno }} {{ $proveedor->persona->apellidomaterno }}</td>
                                    <td class="px-6 py-4">{{ $proveedor->persona->ci }}</td>
                                    <td class="px-6 py-4">{{ $proveedor->persona->telefono }}</td>
                                    <td class="px-6 py-4">{{ $proveedor->nombreempresa }}</td>
                                    <td class="px-6 py-4">{{ $proveedor->cargoempresa }}</td>

                                    <td class="px-6 py-4">
                                        @can('Editar Proveedor')
                                            <x-button wire:click="edit({{ $proveedor->id }})">Editar</x-button>
                                        @endcan
                                        @can('Eliminar Proveedor')
                                            <x-danger-button wire:click="destroy({{ $proveedor->id }})">Eliminar</x-danger-button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    @endcan 
   <form wire:submit="update">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Actualizar Proveedor
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Nombre
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.nombre" />
                    <x-input-error for="postEdit.nombre" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Apellido Paterno
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.apellidopaterno" />
                    <x-input-error for="postEdit.apellidopaterno" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Apellido Materno
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.apellidomaterno" />
                    <x-input-error for="postEdit.apellidomaterno" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Sexo
                    </x-label>
                    <select class="w-full font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.sexo">
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                    <x-input-error for="postEdit.sexo" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Carnet de Identidad
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.ci" />
                    <x-input-error for="postEdit.ci" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Telefono
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.telefono" />
                    <x-input-error for="postEdit.telefono" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Direccion
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.direccion" />
                    <x-input-error for="postEdit.direccion" />
                </div>

                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Correo Electronico
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.email" />
                    <x-input-error for="postEdit.email" />
                </div>


                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Nombre de la Empresa
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.nombreempresa" />
                    <x-input-error for="postEdit.nombreempresa" />
                </div>

                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Cargo del Proveedor en la Empresa
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.cargoempresa" />
                    <x-input-error for="postEdit.cargoempresa" />
                </div>

                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Telefono de Referencia
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.telefonoreferencia" />
                    <x-input-error for="postEdit.telefonoreferencia" />
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-danger-button class="mr-2" wire:click="$set('open', false)">
                        Cancelar
                    </x-danger-button>
                    <x-button>
                        Actualizar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>

        {{-- Modales de Creacion de Proveedor --}}
        <x-dialog-modal wire:model="mostrarModalSucessCreacion">
            <x-slot name="title">
                Creacion del Proveedor
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Nuevo Proveedor creado satisfactoriamente
                    </x-label>
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button class="mr-2" wire:click="$set('mostrarModalSucessCreacion', false)">
                        Aceptar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>

        {{-- Modales de Edicion de Proveedores --}}
        <x-dialog-modal wire:model="mostrarModalSucessEdit">
            <x-slot name="title">
                Actualizacion de datos del Proveedor
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Datos del Proveedor actualizados satisfactoriamente
                    </x-label>
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button class="mr-2" wire:click="$set('mostrarModalSucessEdit', false)">
                        Aceptar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>

        {{-- Modal de Eliminacion del Proveedor--}}
        <x-dialog-modal wire:model="mostrarModalEliminacion">
            <x-slot name="title">
                Eliminacion del Proveedor
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Nuevo Proveedor eliminado satisfactoriamente
                    </x-label>
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button class="mr-2" wire:click="$set('mostrarModalEliminacion', false)">
                        Aceptar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>


    </form>

    <footer class="bg-gray-800 text-white py-4 mt-4">
        <div class="container mx-auto text-center">
            <p> <strong>CONTADOR DE PAGINA PROVEEDORES: {{$contador}} </strong></p>
            <p>&copy; {{ date('Y') }} LINEA SIMPLE - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>



</div>