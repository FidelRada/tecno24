<div>
    @can('Añadir un Nuevo Movimiento')
        <div class="flex justify mb-4">
            <x-button wire:click="$toggle('mostrarFormulario')">+</x-button>
        </div>


        @if ($mostrarFormulario)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <x-label for="motivo"
                            class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                            Motivo
                        </x-label>
                        <x-input id="motivo" class="w-full mt-1" type="text" wire:model="postCreate.motivo" />
                        <x-input-error for="postCreate.motivo" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="fecha" class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                            Fecha
                        </x-label>
                        <x-input id="fecha" class="w-full mt-1" type="date" wire:model="postCreate.fecha" />
                        <x-input-error for="postCreate.fecha" class="mt-2" />
                    </div>


                    {{--Seleccion de tipo de movimiento--}}
                    <x-label class="mb-4 block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight"> Seleccione
                        el tipo de movimiento</x-label>
                    <div class="flex justify-start">
                        <x-button class="mr-2" type="button" wire:click="$set('mostrarProveedor', true)">Ingreso</x-button>

                        <x-button type="button" wire:click="$set('mostrarProveedor', false)">Egreso</x-button>

                    </div>
                    <br>

                    {{--
                    <div class="mb-4">
                        <x-label for="select"
                            class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                            Seleccione un tipo Movimiento
                        </x-label>
                        <select id="select" class="w-full mt-1 form-select" wire:model="postCreate.id_tipo">
                            <option value="">Seleccione...</option>
                            @foreach ($tipos as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                            @endforeach
                        </select>
                        <x-input-error for="elemento" class="mt-2" />
                    </div>
                    --}}

                    {{--Seleccion de Personal--}}
                    <div class="mb-4">
                        <x-label for="select"
                            class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                            Seleccione personal
                        </x-label>
                        <select id="select" class="w-full mt-1 form-select" wire:model="postCreate.id_personal">
                            <option value="">Seleccione el personal</option>
                            @foreach ($empleados as $empleado)
                                <option value="{{$empleado->id}}">{{$empleado->Persona->nombre}}
                                    {{$empleado->Persona->apellidopaterno}} {{$empleado->Persona->apellidomaterno}}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="postCreate.id_personal" class="mt-2" />
                    </div>


                    {{--Seleccion de Proveedor--}}
                    @if ($mostrarProveedor)

                        <div class="mb-4">
                            <x-label for="select"
                                class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                                Seleccione proveedor
                            </x-label>
                            <select id="select" class="w-full mt-1 form-select" wire:model="postCreate.id_proveedor">
                                <option value="">Seleccione...</option>
                                @foreach ($proveedores as $proveedor)
                                    <option value="{{$proveedor->id}}">
                                        {{$proveedor->Persona->nombre}}
                                        {{$proveedor->Persona->apellidopaterno}}
                                        {{$proveedor->Persona->apellidomaterno}}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error for="elemento" class="mt-2" />
                        </div>
                    @endif

                    <div class="flex justify-start mt-4">
                        <x-button type="button" wire:click="$toggle('openModalAgregarInsumo')">Agregar Insumo al
                            Detalle</x-button>
                    </div>
                    {{-- Detalle de Insumos ARRAY --}}
                    <div class="mb-4">
                        <br>
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Detalle de Movimiento
                        </x-label>
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                            <ul class="list-disc list-inside space-y-2">
                                @foreach ($detalleInsumo as $index => $detalle)
                                    <li class="font-semibold text-sm dark:text-gray-200 leading-tight mb-3 flex justify-between"
                                        wire:key="pedidoservicio-{{ $index }}">
                                        <span>{{ $detalle['nombre_insumo'] }}</span>
                                        <span>{{ $detalle['cantidad'] }}</span>
                                        <div>
                                            <x-button type="button" wire:click="editIsumo({{ $index }})">Editar</x-button>
                                            <x-danger-button type="button"
                                                wire:click="removeInsumo({{ $index }})">Eliminar</x-danger-button>

                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <x-button type="submit">Crear</x-button>
                    </div>
                </form>
            </div>
        @endif
    @endcan

    @can('Ver Lista de movimientos')
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr class="font-semibold text-sm text-gray-700 dark:text-gray-200">
                        <th scope="col" class="px-6 py-3 text-left">ID</th>
                        <th scope="col" class="px-6 py-3 text-left">Motivo</th>
                        <th scope="col" class="px-6 py-3 text-left">Fecha</th>
                            <th scope="col" class="px-6 py-3 text-left">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($movimientos as $movimiento)
                            <tr class="text-sm text-gray-700 dark:text-gray-200">
                            <td class="px-6 py-4">{{ $movimiento->id }}</td>
                            <td class="px-6 py-4">{{ $movimiento->motivo }}</td>
                            <td class="px-6 py-4">{{ $movimiento->fecha }}</td>
                                <td class="px-6 py-4">
                                    @can('Ver Informacion del movimiento')
                                        <x-button wire:click="verDetalle({{ $movimiento->id }})">Ver Detalle</x-button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endcan

    {{-- Modal Agregar Insumo --}}
    <x-dialog-modal wire:model="openModalAgregarInsumo">
        <x-slot name="title">
            Agregar Insumo al detalle
        </x-slot>
        <x-slot name="content">
            {{-- Formulario --}}
            <div class="mb-4">
                <x-label for="motivo"
                    class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                    Cantidad
                </x-label>
                <x-input id="motivo" class="w-full mt-1" type="number" wire:model="postModalAgregarInsumo.cantidad" />
                <x-input-error for="postModalAgregarInsumo.cantidad" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-label for="select"
                    class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                    Seleccione un insumo
                </x-label>
                <select id="select" class="w-full mt-1 form-select" wire:model.defer="postModalAgregarInsumo.id_insumo">
                    <option value="">Seleccione...</option>
                    @foreach ($insumos as $insumo)
                        <option value="{{$insumo->id}}">{{$insumo->nombre}}</option>
                    @endforeach
                </select>
                <x-input-error for="postModalAgregarInsumo.id_insumo" class="mt-2" />
            </div>

        </x-slot>
        <x-slot name="footer">
            <x-danger-button class="mr-2" type="button"
                wire:click="$toggle('openModalAgregarInsumo')">Cancelar</x-danger-button>
            <x-button type="button" wire:click="saveModalAgregarInsumo">Crear</x-button>

        </x-slot>
    </x-dialog-modal>

    {{-- Modal Editar Insumo --}}
    <x-dialog-modal wire:model="openModalEditarInsumo">
        <x-slot name="title">
            Editar Insumo al detalle
        </x-slot>
        <x-slot name="content">
            {{-- Formulario --}}
            <div class="mb-4">
                <x-label for="motivo"
                    class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                    Cantidad
                </x-label>
                <x-input id="motivo" class="w-full mt-1" type="number" wire:model="postModalEdit.cantidad" />
                <x-input-error for="postModalEdit.cantidad" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-label for="select"
                    class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                    Seleccione un insumo
                </x-label>
                <select id="select" class="w-full mt-1 form-select" wire:model.defer="postModalEdit.id_insumo">
                    @foreach ($insumos as $insumo)
                        <option value="{{$insumo->id}}">{{$insumo->nombre}}</option>
                    @endforeach
                </select>
                <x-input-error for="postModalEdit.id_insumo" class="mt-2" />
            </div>

        </x-slot>
        <x-slot name="footer">
            <x-danger-button class="mr-2" type="button"
                wire:click="$toggle('openModalEditarInsumo')">Cancelar</x-danger-button>
            <x-button type="button" wire:click="updateModalInsumo">Actualizar</x-button>
        </x-slot>
    </x-dialog-modal>



    {{-- Modal Ver Movimiento --}}

    <x-dialog-modal wire:model="openModalVerDetalleMovimiento">
        <x-slot name="title">
            Detalle del Movimiento
        </x-slot>
        <x-slot name="content">
            @if ($movimiento)

                <br>
                <p><strong>Datos del Movimiento:</strong>
                    <br>
                <p><strong>ID del Movimiento:</strong> {{ $movimiento->id}}</p>
                <p><strong>Tipo Movimiento:</strong> {{ $movimiento->tipoMovimiento->nombre}}</p>
                <p><strong>Motivo:</strong> {{ $movimiento->motivo }}</p>
                <p><strong>Fecha:</strong> {{ $movimiento->fecha }}</p>
                <br>
                <p><strong>Datos del Personal:</strong>
                    <br>
                <p><strong>Id del Personal:</strong> {{ $personal->id }}</p>
                <p><strong>Cargo:</strong> {{ $personal->cargo }}</p>
                <p><strong>CI:</strong> {{ $personal->persona->ci }}</p>
                <p><strong>Nombre del Cliente:</strong> {{ $personal->persona->nombre }}</p>
                <p><strong>Apellido Paterno:</strong> {{ $personal->persona->apellidopaterno }}</p>
                <p><strong>Apellido Materno:</strong> {{ $personal->persona->apellidomaterno }}</p>
                <p><strong>Sexo:</strong> {{ $personal->persona->sexo }}</p>
                <p><strong>Telefono:</strong> {{ $personal->persona->telefono }}</p>
                <p><strong>Direccion:</strong> {{ $personal->persona->direccion }}</p>
                <br>

                @if ($proveedor)

                    <p><strong>Datos del Proveedor:</strong>
                        <br>
                    <p><strong>Id del Proveedor:</strong> {{ $proveedor->id }}</p>
                    <p><strong>Empresa:</strong> {{ $proveedor->nombreempresa }}</p>
                    <p><strong>Cargo:</strong> {{ $proveedor->cargoempresa }}</p>
                    <p><strong>CI:</strong> {{ $proveedor->persona->ci }}</p>
                    <p><strong>Nombre del Cliente:</strong> {{ $proveedor->persona->nombre }}</p>
                    <p><strong>Apellido Paterno:</strong> {{ $proveedor->persona->apellidopaterno }}</p>
                    <p><strong>Apellido Materno:</strong> {{ $proveedor->persona->apellidomaterno }}</p>
                    <p><strong>Sexo:</strong> {{ $proveedor->persona->sexo }}</p>
                    <p><strong>Telefono:</strong> {{ $proveedor->persona->telefono }}</p>
                    <p><strong>Direccion:</strong> {{ $proveedor->persona->direccion }}</p>
                    <br>
                @endif

                <p><strong>Detalle de insumos del Movimiento:</strong>
                    <br>
                    @foreach ($detalleMovimiento as $index => $det)
                        <li class="font-semibold text-sm dark:text-gray-200 leading-tight mb-3"
                            wire:key="pedidodetalle-{{ $index }}">
                            <p><strong>Insumo:</strong>{{$det->insumo->nombre}} {{$det->insumo->marca}} </p>
                            <p><strong>Cantidad:</strong> {{ $det->cantidad}}</p>
                        </li>
                    @endforeach
            @endif
        </x-slot>



        <x-slot name="footer">
            <div class="flex justify-end">
                <x-danger-button class="mr-2" wire:click="$set('openModalVerDetalleMovimiento', false)">
                    Aceptar
                </x-danger-button>
            </div>
        </x-slot>
    </x-dialog-modal>





    {{-- Modales de Creacion de un Movimiento --}}
    <x-dialog-modal wire:model="mostrarModalSucessCreacionMovimiento">
        <x-slot name="title">
            Creacion de un Movimiento
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Nuevo Movimiento creado satisfactoriamente
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalSucessCreacionMovimiento', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modales de Adicion de un insumo al movimiento --}}
    <x-dialog-modal wire:model="mostrarModalSucessCreacionInsumoMovimiento">
        <x-slot name="title">
            Creacion del Insumo en el Movimiento
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Nuevo Insumo en el movimiento adicionado satisfactoriamente
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalSucessCreacionInsumoMovimiento', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal de Actualizacion de un Insumo en Movimiento --}}
    <x-dialog-modal wire:model="mostrarModalSucessEditInsumoMovimiento">
        <x-slot name="title">
            Actualizacion del Insumo en el Movimiento
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Insumo en el Movimiento actualizado satisfactoriamente
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalSucessEditInsumoMovimiento', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal de Eliminacion de un Insumo en el Movimiento --}}
    <x-dialog-modal wire:model="mostrarModalSucessDeleteInsumoMovimiento">
        <x-slot name="title">
            Eliminacion del Insumo en el Movimiento
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Insumo en el Movimiento eliminado satisfactoriamente
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalSucessDeleteInsumoMovimiento', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modales de Error de NO HAY NINGUN INSUMO AÑADIDO AL MOVIMIENTO --}}
    <x-dialog-modal wire:model="mostrarModalEmptyInsumoMovimiento">
        <x-slot name="title">
            Creacion del Movimiento
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    No se pudo realizar el Movimiento debido a que debe añadir al menos un insumo a su movimiento
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalEmptyInsumoMovimiento', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4 mt-4">
        <div class="container mx-auto text-center">
            <p> <strong>CONTADOR DE PAGINA MOVIMIENTOS: {{$contador}} </strong></p>
            <p>&copy; {{ date('Y') }} LINEA SIMPLE - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>

</div>