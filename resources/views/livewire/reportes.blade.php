<div> {{-- Botón para abrir el modal --}}

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
        <x-label class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
            REPORTES
        </x-label>
        <br>
        <div class="mb-4">
            <x-label for="select" class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                Seleccione consulta
            </x-label>
            <select id="select" class="w-full mt-1 form-select" wire:model="consultaSeleccionada">
                <option value="">Seleccione...</option>
                <option value="Movimientos">Movimientos</option>
                <option value="Insumos">Insumos</option>
                <option value="Clientes">Clientes</option>
            </select>
            <x-input-error for="elemento" class="mt-2" />
        </div>

        <div class="flex justify-start mb-4">
            <div class="mr-5">

                <x-label class="w-full mt-1 form-select" for="fechaInicio"
                    class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                    Fecha de inicio
                </x-label>
                <x-input class="w-full mt-1" type="date" wire:model="fecha.inicio" />
                <x-input-error for="fechaInicio" class="mt-2" />
            </div>

            <div class="mr-5">

                <x-label for="fechaFin"
                    class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                    Fecha final
                </x-label>
                <x-input class="w-full mt-1" type="date" wire:model="fecha.fin" />
                <x-input-error for="fechaFin" class="mt-2" />
            </div>

            <div class="flex justify-start mt-4 mr-5">
                <x-button wire:click="filtrar" type="button">Filtrar</x-button>
            </div>
            <div class="flex justify-start mt-4 mr-5">
                <x-button wire:click="descargarPdf" type="button">Descargar pdf</x-button>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <ul class="list-disc list-inside space-y-2">
                @if($mostartMovimientos)
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Motivo</th>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Recepcionado por</th>
                                <th>Proveedor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resultados as $resultado)
                                <tr>
                                    <td>{{ $resultado->id }}</td>
                                    <td>{{ $resultado->motivo }}</td>
                                    <td>{{ $resultado->fecha }}</td>
                                    <td>{{ $resultado->tipomovimiento->nombre }}</td>
                                    <td>
                                        @if($resultado->proveedor)
                                            {{ $resultado->proveedor->nombre }}
                                            {{ $resultado->proveedor->persona->apellidopaterno }}
                                            {{ $resultado->proveedor->persona->apellidomaterno }}
                                        @else
                                            N/A
                                        @endif

                                    </td>
                                    <td>{{ $resultado->personal->persona->nombre }}
                                        {{ $resultado->personal->persona->apellidopaterno }}
                                        {{ $resultado->personal->persona->apellidomaterno }}
                                    </td>
                                    <!-- Añade más campos según tus resultados -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if($mostartInsumos)
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Marca</th>
                                <th>Origen</th>
                                <th>Categoria</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resultados as $resultado)
                                <tr>
                                    <td>{{ $resultado->id }}</td>
                                    <td>{{ $resultado->nombre }}</td>
                                    <td>{{ $resultado->marca }}</td>
                                    <td>{{ $resultado->origen }}</td>
                                    <td>
                                        @if($resultado->categoriainsumo)
                                            {{ $resultado->categoriainsumo->nombre }}
                                        @else
                                            N/A
                                        @endif

                                    </td>
                                    <!-- Añade más campos según tus resultados -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if($mostartClientes)
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>Telefono</th>
                                <th>Sexo</th>
                                <th>NIT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resultados as $resultado)
                                <tr>
                                    <td>{{ $resultado->id }}</td>
                                    <td>{{ $resultado->persona->nombre }} {{ $resultado->persona->apellidopaterno }}
                                        {{ $resultado->persona->apellidomaterno }}
                                    </td>
                                    <td>{{ $resultado->persona->telefono }}</td>
                                    <td>{{ $resultado->persona->sexo }}</td>
                                    <td>
                                        {{ $resultado->nit }}
                                    </td>
                                    <!-- Añade más campos según tus resultados -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                {{--@else
                <p>No hay resultados para mostrar.</p>
                @endif--}}
            </ul>
        </div>

    </div>


    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4 mt-4">

        <div class="container mx-auto text-center">
            {{--
            <p> <strong>CONTADOR: {{$contador}} </strong></p>
            --}}
            <p>&copy; {{ date('Y') }} LINEA SIMPLE - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>


</div>