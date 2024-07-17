<div>
    @can('Añadir un Nuevo Rol y sus Permisos')
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
                            Nombre del Rol
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.nombre" />
                        <x-input-error for="postCreate.nombre" />
                    </div>

                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Permisos
                        </x-label>
                        <ul>
                            @foreach ($permisos as $permiso)
                                <li>
                                    <label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                        <x-checkbox wire:model="postCreate.permisoslist" value="{{ $permiso->id }}" />
                                        {{ $permiso->name }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                        <x-input-error for="postCreate.permisoslist" />
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

    @can('Ver Lista de Roles')
        <!--Formulario para ver los posts creados / En este se aplicara el can-->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr class="font-semibold text-sm text-gray-700 dark:text-gray-200">
                            <th scope="col" class="px-6 py-3 text-left">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($roles as $role)
                            <tr class="text-sm text-gray-700 dark:text-gray-200">
                                <td class="px-6 py-4">{{ $role->name }}</td>
                                <td class="px-6 py-4">
                                    @can('Editar Rol y sus Permisos')
                                        <x-button wire:click="edit({{ $role->id }})">Editar</x-button>
                                    @endcan
                                    @can('Eliminar Rol y sus Permisos')
                                        <x-danger-button wire:click="destroy({{ $role->id }})">Eliminar</x-danger-button>
                                    @endcan
                                    @can('Ver Lista de Permisos del Rol')
                                        <x-button wire:click="listPermissions({{ $role->id }})">Ver Permisos</x-button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endcan



    <form wire:submit="update">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Actualizar Roles y Permisos
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Nombre del Rol
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.nombre" />
                    <x-input-error for="postEdit.nombre" />
                </div>

                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Permisos
                    </x-label>
                    <ul>
                        @foreach ($permisos as $permiso)
                            <li>
                                <label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    <x-checkbox wire:model="postEdit.permisoslist" value="{{ $permiso->id }}" />
                                    {{ $permiso->name }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                    <x-input-error for="postEdit.permisoslist" />
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
    </form>



    <x-dialog-modal wire:model="open2">
        <x-slot name="title">
            Lista de Permisos
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Nombre del Rol
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postEdit.nombre" disabled />
                <x-input-error for="postEdit.nombre" />
            </div>

            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Permisos
                </x-label>
                <ul>
                    @foreach ($permisos as $permiso)
                        @if (in_array($permiso->id, $postEdit['permisoslist']))
                            <li>
                                <label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    <x-checkbox wire:model="postEdit.permisoslist" value="{{ $permiso->id }}" disabled />
                                    {{ $permiso->name }}
                                </label>
                            </li>
                        @endif
                        {{--
                        <li>
                            <label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                <x-checkbox wire:model="postEdit.permisoslist" value="{{ $permiso->id }}" />
                                {{ $permiso->name }}
                            </label>
                        </li>
                        --}}
                    @endforeach
                </ul>
                <x-input-error for="postEdit.permisoslist" />
            </div>


        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-danger-button class="mr-2" wire:click="$set('open2', false)">
                    Atras
                </x-danger-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modales de Creacion de Roles y Permisos --}}
    <x-dialog-modal wire:model="mostrarModalSucessCreacion">
        <x-slot name="title">
            Creacion del Rol con sus permisos
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Nuevo Rol con sus permisos creado satisfactoriamente
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

    {{-- Modales de Edicion de Roles y Permisos --}}
    <x-dialog-modal wire:model="mostrarModalSucessEdit">
        <x-slot name="title">
            Actualizacion del Rol y sus permisos
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Datos del Rol y sus permisos actualizados satisfactoriamente
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

    {{-- Modal de Eliminacion de Rol y sus permisos--}}
    <x-dialog-modal wire:model="mostrarModalEliminacion">
        <x-slot name="title">
            Eliminacion del Rol y sus Permisos
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Rol y sus permisos eliminados satisfactoriamente
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

    <footer class="bg-gray-800 text-white py-4 mt-4">
        <div class="container mx-auto text-center">
            <p> <strong>CONTADOR DE PAGINA ROLES: {{$contador}} </strong></p>
            <p>&copy; {{ date('Y') }} LINEA SIMPLE - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>


</div>