<div>
    @can('Ver Lista de Cotizaciones')
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr class="font-semibold text-sm text-gray-700 dark:text-gray-200">
                            <th scope="col" class="px-6 py-3 text-left">ID</th>

                            <th scope="col" class="px-6 py-3 text-left">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($cotizacions as $cotizacion)
                            <tr class="text-sm text-gray-700 dark:text-gray-200">
                                <td class="px-6 py-4">{{ $cotizacion->pedido_id }}</td>

                                <td class="px-6 py-4">
                                    @if ($cotizacion->pedido->estado == 'Cotizando')
                                        @can('Enviar una cotizacion de un pedido al cliente')
                                            <x-button wire:click="verPedidoCotizacion({{ $cotizacion->id }})">Ver Detalle de la
                                                cotización</x-button>
                                        @endcan
                                    @else
                                        Cotizado
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endcan


    <x-dialog-modal wire:model="openModalDetalleVerPedidoCotizacion">
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
                <!-- Campo de Descripción de la cotización -->
            <div class="mb-4">
                <x-label class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Formulario de Cotizacion al Cliente
                </x-label>
            </div>
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Agrege una descripcion acerca de la cotizacion que sera enviada al cliente
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postModalCotizacion.descripcioncotizacion" />
                <x-input-error for="postModalCotizacion.descripcioncotizacion" />
            </div>

            <!-- Campo de Costo de la cotización -->
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Agrege el costo de la cotizacion
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postModalCotizacion.costo" />
                <x-input-error for="postModalCotizacion.costo" />
            </div>

            <!-- Campo de URL de Repositorio de la cotización -->
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Agrege una URL de Repositorio donde se encontrara el pdf de la cotizacion
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postModalCotizacion.url" />
                <x-input-error for="postModalCotizacion.url" />
            </div>

        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-danger-button class="mr-2" wire:click="$set('openModalDetalleVerPedidoCotizacion', false)">
                    Cancelar
                </x-danger-button>
                <x-button type="button" wire:click="enviarCotizacion">
                    Enviar Cotizacion
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="mostrarModalEnviarCotizacion">
        <x-slot name="title">
            Enviar Cotizacion al Cliente
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Se envio la Cotizacion del Pedido al Cliente
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalEnviarCotizacion', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
    <footer class="bg-gray-800 text-white py-4 mt-4">
        <div class="container mx-auto text-center">
            <p> <strong>CONTADOR DE PAGINA COTIZACION: {{$contador}} </strong></p>
            <p>&copy; {{ date('Y') }} LINEA SIMPLE - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>


</div>