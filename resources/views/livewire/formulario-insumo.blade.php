<div>
    @can('Añadir un Nuevo Insumo')
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
                            Marca
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.marca" />
                        <x-input-error for="postCreate.marca" />
                    </div>
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Origen (Pais de donde proviene)
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.origen"></x-input>
                        <x-input-error for="postCreate.origen" />
                    </div>
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Categoria de Insumo
                        </x-label>
                        <x-select class="w-full" wire:model="postCreate.categoria_insumo_id">

                            <option value="" disabled>Seleccione una Categoria de Insumo</option>

                            @foreach ($categoriainsumos as $categoriainsumo)
                                <option value="{{ $categoriainsumo->id }}">{{ $categoriainsumo->nombre }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error for="postCreate.categoria_insumo_id" />
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


    <!--Formulario para ver los posts creados / En este se aplicara el can-->
    @can('Ver Lista de Insumos')
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr class="font-semibold text-sm text-gray-700 dark:text-gray-200">
                        <th scope="col" class="px-6 py-3 text-left">ID</th>
                        <th scope="col" class="px-6 py-3 text-left">Nombre</th>
                        <th scope="col" class="px-6 py-3 text-left">Marca</th>
                        <th scope="col" class="px-6 py-3 text-left">Origen</th>
                            <th scope="col" class="px-6 py-3 text-left">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($insumos as $insumo)
                            <tr class="text-sm text-gray-700 dark:text-gray-200">
                            <td class="px-6 py-4">{{ $insumo->id }}</td>
                            <td class="px-6 py-4">{{ $insumo->nombre }}</td>
                            <td class="px-6 py-4">{{ $insumo->marca }}</td>
                            <td class="px-6 py-4">{{ $insumo->origen }}</td>
                                <td class="px-6 py-4">
                                    @can('Editar un Insumo')
                                        <x-button wire:click="edit({{ $insumo->id }})">Editar</x-button>
                                    @endcan
                                    @can('Eliminar un Insumo')
                                        <x-danger-button wire:click="destroy({{ $insumo->id }})">Eliminar</x-danger-button>
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
                Actualizar Post
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
                        Marca
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.marca" />
                    <x-input-error for="postEdit.marca" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        origen
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.origen"></x-input>
                    <x-input-error for="postEdit.origen" />
                </div>

                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Categoria de Insumo
                    </x-label>
                    <x-select class="w-full" wire:model="postEdit.categoria_insumo_id">

                        @foreach ($categoriainsumos as $categoriainsumo)
                            <option value="{{ $categoriainsumo->id }}">{{ $categoriainsumo->nombre }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postEdit.categoria_insumo_id" />
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

        {{-- Modales de Creacion de Insumos --}}
        <x-dialog-modal wire:model="mostrarModalSucessCreacion">
            <x-slot name="title">
                Creacion del Insumo
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Nuevo Insumo creado satisfactoriamente
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

        {{-- Modales de Edicion del Insumo --}}
        <x-dialog-modal wire:model="mostrarModalSucessEdit">
            <x-slot name="title">
                Actualizacion de datos del Insumo
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Datos del Insumo actualizados satisfactoriamente
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

        {{-- Modal de Eliminacion del Insumo--}}
        <x-dialog-modal wire:model="mostrarModalEliminacion">
            <x-slot name="title">
                Eliminacion del Insumo
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Insumo eliminado satisfactoriamente
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
            <p> <strong>CONTADOR DE PAGINA INSUMOS: {{$contador}} </strong></p>
            <p>&copy; {{ date('Y') }} LINEA SIMPLE - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>

</div>