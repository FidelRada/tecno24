<div>
    @can('Añadir una Nueva Categoria de Insumo')
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
                            Descripcion
                        </x-label>
                        <x-textarea class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.descripcion"></x-textarea>
                        <x-input-error for="postCreate.descripcion" />
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
    @can('Ver Lista de Categorias de Insumos')
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr class="font-semibold text-sm text-gray-700 dark:text-gray-200">
                        <th scope="col" class="px-6 py-3 text-left">Nombre</th>
                        <th scope="col" class="px-6 py-3 text-left">Descripcion</th>
                            <th scope="col" class="px-6 py-3 text-left">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($categoriainsumos as $categoriainsumo)
                            <tr class="text-sm text-gray-700 dark:text-gray-200">
                            <td class="px-6 py-4">{{ $categoriainsumo->nombre }}</td>
                            <td class="px-6 py-4">{{ $categoriainsumo->descripcion }}</td>
                                <td class="px-6 py-4">
                                    @can('Editar una Categoria de Insumo')
                                        <x-button wire:click="edit({{ $categoriainsumo->id }})">Editar</x-button>
                                    @endcan
                                    @can('Eliminar una Categoria de Insumo')
                                        <x-danger-button wire:click="destroy({{ $categoriainsumo->id }})">Eliminar</x-danger-button>
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
                Actualizar Categoria de Insumo
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
                        Descripcion
                    </x-label>
                    <x-textarea class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.descripcion"></x-textarea>
                    <x-input-error for="postEdit.descripcion" />
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

        {{-- Modales de Creacion de Categoria de Insumo --}}
        <x-dialog-modal wire:model="mostrarModalSucessCreacion">
            <x-slot name="title">
                Creacion del Categoria de Insumo
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Nuevo Categoria de Insumo creado satisfactoriamente
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

        {{-- Modales de Edicion de Categoria de Insumo --}}
        <x-dialog-modal wire:model="mostrarModalSucessEdit">
            <x-slot name="title">
                Actualizacion de datos de la Categoria de Insumo
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Datos de la Categoria de Insumo actualizados satisfactoriamente
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

        {{-- Modal de Eliminacion de la Categoria de Insumo--}}
        <x-dialog-modal wire:model="mostrarModalEliminacion">
            <x-slot name="title">
                Eliminacion de la Categoria de Insumo
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Categoria de Insumo eliminado satisfactoriamente
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
            <p> <strong>CONTADOR DE PAGINA CATEGORIA DE INSUMOS: {{$contador}} </strong></p>
            <p>&copy; {{ date('Y') }} LINEA SIMPLE - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>



</div>