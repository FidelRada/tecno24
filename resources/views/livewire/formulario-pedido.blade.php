<div>
    @can('Añadir un Nuevo Pedido')
        <div class="flex justify mb-4">
            <x-button wire:click="toggleCreateForm">
                +
            </x-button>
        </div>

        {{-- Formulario de Creacion de un pedido --}}
        @if ($mostrarFormulario)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Descripcion General del Pedido
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                            wire:model="postCreate.descripciongeneral" />
                        <x-input-error for="postCreate.descripciongeneral" />
                    </div>
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Fecha de Entrega
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" type="date"
                            wire:model="postCreate.fechaEntrega" />
                        <x-input-error for="postCreate.fechaEntrega" />
                    </div>
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Seleccion del Cliente del Pedido
                        </x-label>
                        <div>
                            <select
                                class="block w-full mt-1 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                wire:model="postCreate.cliente_id">
                                <option value="">Selecciona un Cliente</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->persona->nombre }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="postCreate.cliente_id" />
                        </div>
                    </div>
                    {{-- Botones para seleccionar un servicio de pedido para el pedido --}}
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Seleccione su Servicio para el pedido
                        </x-label>
                        <div>
                            <li class="font-semibold text-sm dark:text-gray-200 leading-tight mb-3 flex justify-between">
                                <div>
                                    <x-button type="button" wire:click="$set('openModalDiseño', true)">Diseño</x-button>
                                    <x-button type="button" wire:click="$set('openModalImpresion', true)">Impresion</x-button>
                                    <x-button type="button"
                                        wire:click="$set('openModalArquitectura', true)">Arquitectura</x-button>
                                    <x-button type="button" wire:click="$set('openModalBastidor', true)">Bastidor</x-button>
                                    <x-button type="button"
                                        wire:click="$set('openModalAcondicionamiento', true)">Acondicionamiento</x-button>

                                </div>
                            </li>
                        </div>
                    </div>
                    {{-- Lista en un Array de los detalles de servicios de Pedidos --}}
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Lista de Detalle de Pedido de Servicios
                        </x-label>
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                            <ul class="list-disc list-inside space-y-2">
                                @foreach ($detallePedidosServiciosArray as $index => $servicio)
                                    <li class="font-semibold text-sm dark:text-gray-200 leading-tight mb-3 flex justify-between"
                                        wire:key="pedidoservicio-{{ $index }}">
                                        <span>{{ $servicio['descripcion'] }}</span>
                                        <div>
                                            {{-- Boton para Editar un Servicio en el pedido --}}
                                            <x-button type="button" wire:click="editModal({{ $index }})">Editar</x-button>
                                            {{-- Boton para Eliminar un Servicio en el pedido --}}
                                            <x-danger-button type="button"
                                                wire:click="deleteModal({{ $index }})">Eliminar</x-danger-button>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    {{-- Abrir el Modal de Diseno en el pedido --}}
                    <x-dialog-modal wire:model="openModalDiseño">
                        <x-slot name="title">
                            Pedido de Diseño
                        </x-slot>
                        <x-slot name="content">
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una descripcion para su pedido de Diseño
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalDiseño.descripcion" />
                                <x-input-error for="postModalDiseño.descripcion" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una URL de Repositorio para sus diseños(Opcional)
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalDiseño.url" />
                                <x-input-error for="postModalDiseño.url" />
                            </div>

                        </x-slot>
                        <x-slot name="footer">
                            <div class="flex justify-end">
                                <x-danger-button class="mr-2" wire:click="$set('openModalDiseño', false)">
                                    Cancelar
                                </x-danger-button>
                                <x-button type="button" wire:click="saveModalDiseño">
                                    Registrar Pedido de Servicio
                                </x-button>
                            </div>
                        </x-slot>
                    </x-dialog-modal>
                    {{-- Abrir el Modal de Impresion en el pedido --}}
                    <x-dialog-modal wire:model="openModalImpresion">
                        <x-slot name="title">
                            Pedido de Impresion
                        </x-slot>
                        <x-slot name="content">
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una descripcion para su pedido de Impresion
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalImpresion.descripcion" />
                                <x-input-error for="postModalImpresion.descripcion" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una URL de Repositorio para sus diseños de Impresion (Opcional)
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalImpresion.url" />
                                <x-input-error for="postModalImpresion.url" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el Material a usar
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalImpresion.material" />
                                <x-input-error for="postModalImpresion.material" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el Ancho del diseño
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalImpresion.ancho" />
                                <x-input-error for="postModalImpresion.ancho" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el Alto del diseño
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalImpresion.alto" />
                                <x-input-error for="postModalImpresion.alto" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique la cantidad de diseños
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalImpresion.cantidad" />
                                <x-input-error for="postModalImpresion.cantidad" />
                            </div>
                        </x-slot>
                        <x-slot name="footer">
                            <div class="flex justify-end">
                                <x-danger-button class="mr-2" wire:click="$set('openModalImpresion', false)">
                                    Cancelar
                                </x-danger-button>
                                <x-button type="button" wire:click="saveModalImpresion">
                                    Registrar Pedido de Servicio
                                </x-button>
                            </div>
                        </x-slot>
                    </x-dialog-modal>
                    {{-- Abrir el Modal de Arquitectura en el pedido --}}
                    <x-dialog-modal wire:model="openModalArquitectura">
                        <x-slot name="title">
                            Pedido de Arquitectura
                        </x-slot>
                        <x-slot name="content">
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una descripcion para su pedido de Arquitectura
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalArquitectura.descripcion" />
                                <x-input-error for="postModalArquitectura.descripcion" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una URL de Repositorio para sus diseños de Arquitectura (Opcional)
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalArquitectura.url" />
                                <x-input-error for="postModalArquitectura.url" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique los formatos de salida del trabajo de arquitectura
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalArquitectura.formato" />
                                <x-input-error for="postModalArquitectura.formato" />
                            </div>
                        </x-slot>
                        <x-slot name="footer">
                            <div class="flex justify-end">
                                <x-danger-button class="mr-2" wire:click="$set('openModalArquitectura', false)">
                                    Cancelar
                                </x-danger-button>
                                <x-button type="button" wire:click="saveModalArquitectura">
                                    Registrar Pedido de Servicio
                                </x-button>
                            </div>
                        </x-slot>
                    </x-dialog-modal>
                    {{-- Abrir el Modal de Bastidor en el pedido --}}
                    <x-dialog-modal wire:model="openModalBastidor">
                        <x-slot name="title">
                            Pedido de Bastidor
                        </x-slot>
                        <x-slot name="content">
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una descripcion para su pedido de Bastidor
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalBastidor.descripcion" />
                                <x-input-error for="postModalBastidor.descripcion" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una URL de Repositorio para sus diseños de Bastidor (Opcional)
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalBastidor.url" />
                                <x-input-error for="postModalBastidor.url" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el Material a usar
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalBastidor.material" />
                                <x-input-error for="postModalBastidor.material" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el Ancho del Bastidor
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalBastidor.ancho" />
                                <x-input-error for="postModalBastidor.ancho" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el Alto del Bastidor
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalBastidor.alto" />
                                <x-input-error for="postModalBastidor.alto" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el diseño del Bastidor
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalBastidor.diseño" />
                                <x-input-error for="postModalBastidor.diseño" />
                            </div>
                        </x-slot>
                        <x-slot name="footer">
                            <div class="flex justify-end">
                                <x-danger-button class="mr-2" wire:click="$set('openModalBastidor', false)">
                                    Cancelar
                                </x-danger-button>
                                <x-button type="button" wire:click="saveModalBastidor">
                                    Registrar Pedido de Servicio
                                </x-button>
                            </div>
                        </x-slot>
                    </x-dialog-modal>
                    {{-- Abrir el Modal de Acondicionamiento en el pedido --}}
                    <x-dialog-modal wire:model="openModalAcondicionamiento">
                        <x-slot name="title">
                            Pedido de Acondicionamiento
                        </x-slot>
                        <x-slot name="content">
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una descripcion para su pedido de Acondicionamiento
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalAcondicionamiento.descripcion" />
                                <x-input-error for="postModalAcondicionamiento.descripcion" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una URL de Repositorio de sus fotos del local (Opcional)
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalAcondicionamiento.url" />
                                <x-input-error for="postModalAcondicionamiento.url" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege un formato del tipo de local que se buscara acondicionar
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalAcondicionamiento.formato" />
                                <x-input-error for="postModalAcondicionamiento.formato" />
                            </div>
                        </x-slot>
                        <x-slot name="footer">
                            <div class="flex justify-end">
                                <x-danger-button class="mr-2" wire:click="$set('openModalAcondicionamiento', false)">
                                    Cancelar
                                </x-danger-button>
                                <x-button type="button" wire:click="saveModalAcondicionamiento">
                                    Registrar Pedido de Servicio
                                </x-button>
                            </div>
                        </x-slot>
                    </x-dialog-modal>
                    {{-- Abrir el Modal de Edicion de Diseno en el pedido --}}
                    <x-dialog-modal wire:model="openModalEditDiseño">
                        <x-slot name="title">
                            Actualizacion de Pedido de Diseño
                        </x-slot>
                        <x-slot name="content">
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege la actualizacion de la descripcion para su pedido de Diseño
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditDiseño.descripcion" />
                                <x-input-error for="postModalEditDiseño.descripcion" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una URL de Repositorio para sus diseños(Opcional)
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditDiseño.url" />
                                <x-input-error for="postModalEditDiseño.url" />
                            </div>
                        </x-slot>
                        <x-slot name="footer">
                            <div class="flex justify-end">
                                <x-danger-button class="mr-2" wire:click="$set('openModalEditDiseño', false)">
                                    Cancelar
                                </x-danger-button>
                                <x-button type="button" wire:click="updateModal">
                                    Actualizar Pedido de Servicio
                                </x-button>
                            </div>
                        </x-slot>
                    </x-dialog-modal>
                    {{-- Abrir el Modal de Edicion de Impresion en el pedido --}}
                    <x-dialog-modal wire:model="openModalEditImpresion">
                        <x-slot name="title">
                            Actualizacion de Pedido de Impresion
                        </x-slot>
                        <x-slot name="content">
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege la actualizacion de la descripcion para su pedido de Impresion
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditImpresion.descripcion" />
                                <x-input-error for="postModalEditImpresion.descripcion" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una URL de Repositorio para sus diseños de Impresion (Opcional)
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditImpresion.url" />
                                <x-input-error for="postModalEditImpresion.url" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el Material a usar
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditImpresion.material" />
                                <x-input-error for="postModalEditImpresion.material" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el Ancho del diseño
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditImpresion.ancho" />
                                <x-input-error for="postModalEditImpresion.ancho" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el Alto del diseño
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditImpresion.alto" />
                                <x-input-error for="postModalEditImpresion.alto" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique la cantidad de diseños
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditImpresion.cantidad" />
                                <x-input-error for="postModalEditImpresion.cantidad" />
                            </div>
                        </x-slot>
                        <x-slot name="footer">
                            <div class="flex justify-end">
                                <x-danger-button class="mr-2" wire:click="$set('openModalEditImpresion', false)">
                                    Cancelar
                                </x-danger-button>
                                <x-button type="button" wire:click="updateModal">
                                    Actualizar Pedido de Servicio
                                </x-button>
                            </div>
                        </x-slot>
                    </x-dialog-modal>
                    {{-- Abrir el Modal de Edicion de Arquitectura en el pedido --}}
                    <x-dialog-modal wire:model="openModalEditArquitectura">
                        <x-slot name="title">
                            Actualizacion de Pedido de Arquitectura
                        </x-slot>
                        <x-slot name="content">
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege la actualizacion de la descripcion para su pedido de Arquitectura
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditArquitectura.descripcion" />
                                <x-input-error for="postModalEditArquitectura.descripcion" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una URL de Repositorio para sus diseños de Arquitectura (Opcional)
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditArquitectura.url" />
                                <x-input-error for="postModalEditArquitectura.url" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique los formatos de salida del trabajo de arquitectura
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditArquitectura.formato" />
                                <x-input-error for="postModalEditArquitectura.formato" />
                            </div>
                        </x-slot>
                        <x-slot name="footer">
                            <div class="flex justify-end">
                                <x-danger-button class="mr-2" wire:click="$set('openModalEditArquitectura', false)">
                                    Cancelar
                                </x-danger-button>
                                <x-button type="button" wire:click="updateModal">
                                    Actualizar Pedido de Servicio
                                </x-button>
                            </div>
                        </x-slot>
                    </x-dialog-modal>
                    {{-- Abrir el Modal de Edicion de Bastidor en el pedido --}}
                    <x-dialog-modal wire:model="openModalEditBastidor">
                        <x-slot name="title">
                            Actualizacion de Pedido de Bastidor
                        </x-slot>
                        <x-slot name="content">
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege la actualizacion de la descripcion para su pedido de Bastidor
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditBastidor.descripcion" />
                                <x-input-error for="postModalEditBastidor.descripcion" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una URL de Repositorio para sus diseños de Bastidor (Opcional)
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditBastidor.url" />
                                <x-input-error for="postModalEditBastidor.url" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el Material a usar
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditBastidor.material" />
                                <x-input-error for="postModalEditBastidor.material" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el Ancho del Bastidor
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditBastidor.ancho" />
                                <x-input-error for="postModalEditBastidor.ancho" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el Alto del Bastidor
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditBastidor.alto" />
                                <x-input-error for="postModalEditBastidor.alto" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Especifique el diseño del Bastidor
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditBastidor.diseño" />
                                <x-input-error for="postModalEditBastidor.diseño" />
                            </div>
                        </x-slot>
                        <x-slot name="footer">
                            <div class="flex justify-end">
                                <x-danger-button class="mr-2" wire:click="$set('openModalEditBastidor', false)">
                                    Cancelar
                                </x-danger-button>
                                <x-button type="button" wire:click="updateModal">
                                    Actualizar Pedido de Servicio
                                </x-button>
                            </div>
                        </x-slot>
                    </x-dialog-modal>
                    {{-- Abrir el Modal de Edicion de Acondicionamiento en el pedido --}}
                    <x-dialog-modal wire:model="openModalEditAcondicionamiento">
                        <x-slot name="title">
                            Actualizacion de Pedido de Acondicionamiento
                        </x-slot>
                        <x-slot name="content">
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege la actualizacion de la descripcion para su pedido de Acondicionamiento
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditAcondicionamiento.descripcion" />
                                <x-input-error for="postModalEditAcondicionamiento.descripcion" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege una URL de Repositorio de sus fotos del local (Opcional)
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditAcondicionamiento.url" />
                                <x-input-error for="postModalEditAcondicionamiento.url" />
                            </div>
                            <div class="mb-4">
                                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    Agrege un formato del tipo de local que se buscara acondicionar
                                </x-label>
                                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                                    wire:model="postModalEditAcondicionamiento.formato" />
                                <x-input-error for="postModalEditAcondicionamiento.formato" />
                            </div>
                        </x-slot>
                        <x-slot name="footer">
                            <div class="flex justify-end">
                                <x-danger-button class="mr-2" wire:click="$set('openModalEditAcondicionamiento', false)">
                                    Cancelar
                                </x-danger-button>
                                <x-button type="button" wire:click="updateModal">
                                    Actualizar Pedido de Servicio
                                </x-button>
                            </div>
                        </x-slot>
                    </x-dialog-modal>

                    {{-- Boton para crear el pedido --}}
                    <div class="mt-4 flex justify-end">
                        <x-button type="submit">
                            Crear
                        </x-button>
                    </div>
                </form>
            </div>
        @endif
    @endcan






    @can('Ver Lista de Pedidos')
        <!--Formulario para ver los posts creados / En este se aplicara el can-->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr class="font-semibold text-sm text-gray-700 dark:text-gray-200">
                            <th scope="col" class="px-6 py-3 text-left">Descripción General</th>
                            <th scope="col" class="px-6 py-3 text-left">Estado</th>
                            <th scope="col" class="px-6 py-3 text-left">Fecha de entrega</th>
                            
                            <th scope="col" class="px-6 py-3 text-left">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($pedidos as $pedido)
                            <tr class="text-sm text-gray-700 dark:text-gray-200">
                                <td class="px-6 py-4">{{ $pedido->descripciongeneral }}</td>
                                <td class="px-6 py-4">{{ $pedido->estado }}</td>
                                <td class="px-6 py-4">{{ $pedido->fechaEntrega }}</td>
                                
                                <td class="px-6 py-4">
                                    <div>
                                        @if ($pedido->estado == 'Cotizado')
                                            @can('Ver cotizacion recibida')
                                                <x-button wire:click="verCotizacion({{ $pedido->id }})">Ver Cotización del
                                                    Pedido</x-button>
                                            @endcan
                                        @endif
                                        @can('Solicitar una cotizacion para un pedido')
                                            <x-button wire:click="detallePedidoFromFront({{ $pedido->id }})">Ver Detalle del
                                                Pedido</x-button>
                                        @endcan
                                        @can('Eliminar un Pedido')
                                            <x-danger-button wire:click="destroy({{ $pedido->id }})">Eliminar</x-danger-button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endcan 
    <x-dialog-modal wire:model="openModalDetallePedido">
        <x-slot name="title">
            Detalle del Pedido
        </x-slot>
        <x-slot name="content">
            @if ($pedidoDetail)
                <br>
                <p><strong>Datos del Pedido:</strong>
                    <br>
                <p><strong>ID del Pedido:</strong> {{ $pedidoDetail->id}}</p>
                <p><strong>Descripcion General:</strong> {{ $pedidoDetail->descripciongeneral }}</p>
                <p><strong>Fecha de Entrega:</strong> {{ $pedidoDetail->fechaEntrega }}</p>
                <p><strong>Estado del Pedido:</strong> {{ $pedidoDetail->estado }}</p>
                <br>
                <p><strong>Datos del Cliente:</strong>
                    <br>
                <p><strong>Id del Cliente:</strong> {{ $pedidoDetail->cliente->id }}</p>
                <p><strong>NIT del Cliente:</strong> {{ $pedidoDetail->cliente->nit }}</p>
                <p><strong>CI:</strong> {{ $personaDetail->cliente->persona->ci }}</p>
                <p><strong>Nombre del Cliente:</strong> {{ $personaDetail->cliente->persona->nombre }}</p>
                <p><strong>Apellido Paterno:</strong> {{ $personaDetail->cliente->persona->apellidopaterno }}</p>
                <p><strong>Apellido Materno:</strong> {{ $personaDetail->cliente->persona->apellidomaterno }}</p>
                <p><strong>Sexo:</strong> {{ $personaDetail->cliente->persona->sexo }}</p>
                <p><strong>Telefono:</strong> {{ $personaDetail->cliente->persona->telefono }}</p>
                <p><strong>Direccion:</strong> {{ $personaDetail->cliente->persona->direccion }}</p>
            @endif
            <br>
            <p><strong>Servicios Añadidos al Pedido:</strong>
                <br>
                @foreach ($resultadoDetail as $index => $detalle)
                    <li class="font-semibold text-sm dark:text-gray-200 leading-tight mb-3"
                        wire:key="pedidodetalle-{{ $index }}">
                        @if (!empty($detalle['diseño']))
                            <p><strong>Diseño:</strong>
                            <p><strong>Descripcion:</strong> {{ $detalle['descripcion']}}</p>
                            <p><strong>URL:</strong> {{ $detalle['url']}}</p>
                        @endif
                        @if (!empty($detalle['impresion']))
                            <p><strong>Impresion:</strong>
                            <p><strong>Descripcion:</strong> {{ $detalle['descripcion']}}</p>
                            <p><strong>URL:</strong> {{ $detalle['url']}}</p>
                            <p><strong>Material:</strong> {{ $detalle['impresion']['material'] }}</p>
                            <p><strong>Ancho:</strong> {{ $detalle['impresion']['ancho'] }}</p>
                            <p><strong>Alto:</strong> {{ $detalle['impresion']['alto'] }}</p>
                            <p><strong>Cantidad:</strong> {{ $detalle['impresion']['cantidad'] }}</p>
                        @endif
                        @if (!empty($detalle['arquitectura']))
                            <p><strong>Arquitectura:</strong>
                            <p><strong>Descripcion:</strong> {{ $detalle['descripcion']}}</p>
                            <p><strong>URL:</strong> {{ $detalle['url']}}</p>
                            <p><strong>Formato:</strong> {{ $detalle['arquitectura']['formato'] }}</p>
                        @endif
                        @if (!empty($detalle['bastidor']))
                            <p><strong>Bastidor:</strong>
                            <p><strong>Descripcion:</strong> {{ $detalle['descripcion']}}</p>
                            <p><strong>URL:</strong> {{ $detalle['url']}}</p>
                            <p><strong>Material:</strong> {{ $detalle['bastidor']['material'] }}</p>
                            <p><strong>Ancho:</strong> {{ $detalle['bastidor']['ancho'] }}</p>
                            <p><strong>Alto:</strong> {{ $detalle['bastidor']['alto'] }}</p>
                            <p><strong>Diseño:</strong> {{ $detalle['bastidor']['diseño'] }}</p>
                        @endif
                        @if (!empty($detalle['acondicionamiento']))
                            <p><strong>Acondicionamiento:</strong>
                            <p><strong>Descripcion:</strong> {{ $detalle['descripcion']}}</p>
                            <p><strong>URL:</strong> {{ $detalle['url']}}</p>
                            <p><strong>Formato:</strong> {{ $detalle['acondicionamiento']['formato'] }}</p>
                        @endif
                    </li>
                @endforeach                
            </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-danger-button class="mr-2" wire:click="$set('openModalDetallePedido', false)">
                    Cancelar
                </x-danger-button>
                @if($pedidoDetail)
                    @if ($pedidoDetail->estado == 'Pendiente')
                        <x-button type="button" wire:click="procesarPedido">
                            Procesar el Pedido (Solicitar Cotizacion)
                        </x-button>
                    @elseif ($pedidoDetail->estado == 'Cotizando')
                        <x-button type="button" wire:click="">
                            Cotizando...
                        </x-button>
                    @elseif ($pedidoDetail->estado == 'Cotizado')
                        <x-button type="button" wire:click="">
                            Cotizado
                        </x-button>
                    @elseif ($pedidoDetail->estado == 'Pagado')
                        <x-button type="button" wire:click="">
                            Su pedido ya fue pagado
                        </x-button>
                    @else
                        <x-button type="button" wire:click="">
                            Si se debe agregar algo mas aqui porfavor
                        </x-button>
                    @endif
                @endif
            </div>
        </x-slot>
    </x-dialog-modal>


    <x-dialog-modal wire:model="openModalCotizacion">
        <x-slot name="title">
            Detalle de la Cotizacion
        </x-slot>
        <x-slot name="content">
            @if ($cotizacionDetails)
                @foreach ($cotizacionDetails as $cotizacionDetail)
                    <br>
                    <p><strong>Datos de la Cotizacion:</strong>
                        <br>
                    <p><strong>Descripcion sobre la cotizacion:</strong> {{ $cotizacionDetail['descripcioncotizacion'] }}</p>
                    <p><strong>Costo de la Cotizacion:</strong> {{ $cotizacionDetail['costo'] }}</p>
                    <p><strong>URL del PDF de la cotizacion:</strong> {{ $cotizacionDetail['url'] }}</p>
                @endforeach
            @endif  
            @if ($mostrarQR)
                <p><strong>Escanee su QR porfavor:</strong>
                <p><strong>Aqui esta su QR</strong>
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 py-5">
                    <div class="row d-flex justify-content-center">
                        <img src="{{ $imageUrl }}" alt="Imagen" style="width: 100%; height: 495px;" />
                        {{--<img src="postCreateImg" name="" style="width: 100%; height: 495px;"></img>--}}
                    </div>
                </div>
            @endif  
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                @if($clickInProcessPago)
                    <x-danger-button class="mr-2" wire:click="cancelarPagoQR">
                        Cerrar
                    </x-danger-button>
                    <x-button type="button" wire:click="">
                        Pago Procesado con QR
                    </x-button>
                @else
                    <x-danger-button class="mr-2" wire:click="cancelarPagoQR">
                        Cancelar
                    </x-danger-button>
                    <x-button type="button" wire:click="procesarPagoQR">
                        Procesar el Pago (Solicitar Pago con QR)
                    </x-button>
                @endif  
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modales de Creacion de Pedidos --}}
    <x-dialog-modal wire:model="mostrarModalSucessCreacionPedido">
        <x-slot name="title">
            Creacion del Pedido
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Nuevo Pedido creado satisfactoriamente
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalSucessCreacionPedido', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modales de Adicion de un servicio de Pedidos --}}
    <x-dialog-modal wire:model="mostrarModalSucessCreacionServicioPedido">
        <x-slot name="title">
            Creacion del Servicio del Pedido
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Nuevo Servicio añadido al Pedido satisfactoriamente
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalSucessCreacionServicioPedido', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal de Actualizacion de un servicio de Pedidos --}}
    <x-dialog-modal wire:model="mostrarModalSucessEditServicioPedido">
        <x-slot name="title">
            Actualizacion del Servicio del Pedido
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Servicio del Pedido actualizado satisfactoriamente
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalSucessEditServicioPedido', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal de Eliminacion de un servicio de Pedidos --}}
    <x-dialog-modal wire:model="mostrarModalSucessDeleteServicioPedido">
        <x-slot name="title">
            Eliminacion del Servicio del Pedido
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Servicio del Pedido eliminado satisfactoriamente
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalSucessDeleteServicioPedido', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modales de Error de NO HAY NINGUN SERVICIO AÑADIDO --}}
    <x-dialog-modal wire:model="mostrarModalEmptyServicioPedido">
        <x-slot name="title">
            Creacion del Pedido
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    No se pudo realizar el Pedido debido a que debe añadir al menos un servicio a su pedido
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalEmptyServicioPedido', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal de Eliminacion del Pedido--}}
    <x-dialog-modal wire:model="mostrarModalEliminacionPedido">
        <x-slot name="title">
            Eliminacion del Pedido
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Pedido eliminado satisfactoriamente
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalEliminacionPedido', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal de Procesar el Pedido--}}
    <x-dialog-modal wire:model="mostrarModalProcesarPedido">
        <x-slot name="title">
            Procesar Pedido (Pedir una Cotizacion)
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Pedido de Cotizacion enviado satisfactoriamente
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalProcesarPedido', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
    {{--@endcan--}}

    {{-- Modal de QR generado exitosamente--}}
    <x-dialog-modal wire:model="mostrarModalQRsucess">
        <x-slot name="title">
            Solicitud de Pago del Pedido
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    QR Generado Exitosamente
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalQRsucess', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    <footer class="bg-gray-800 text-white py-4 mt-4">
        <div class="container mx-auto text-center">
            <p> <strong>CONTADOR DE PAGINA PEDIDOS: {{$contador}} </strong></p>
            <p>&copy; {{ date('Y') }} LINEA SIMPLE - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>
</div>