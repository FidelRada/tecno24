<div class="flex justify-end">
    <div class="relative w-3/5">
        <x-input class="w-full" type="text" 
        wire:focus="buscar"
        wire:model="query"
        wire:blur="clearResults" 
        wire:keydown="buscar" placeholder="Buscar..." />

        @if($mostrarResultados)
            <div class="absolute z-10 mt-1 w-full bg-white rounded-md shadow-lg right-0">
                <ul class="py-1">
                    @foreach($results as $index => $result)
                        <li class="px-4 py-2 cursor-pointer hover:bg-gray-100" wire:click="mostrarModalBusqueda({{$index}})">
                            {{-- Aquí ajusta cómo mostrar cada resultado --}}
                            {{ $result->getTypeAndContent()  }} {{-- Ejemplo de campo para mostrar --}}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    {{--model busqueda--}}
    <x-dialog-modal wire:model="openModalBusqueda">
        <x-slot name="title">
            Detalle del Movimiento
        </x-slot>
        <x-slot name="content">
            <br>
            {{$resultadoIndex}}
            {{--
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
                --}}
        </x-slot>


        <x-slot name="footer">
            <div class="flex justify-end">
                <x-danger-button class="mr-2" wire:click="$set('openModalBusqueda', false)">
                    OK
                </x-danger-button>
            </div>
        </x-slot>
    </x-dialog-modal>



</div>