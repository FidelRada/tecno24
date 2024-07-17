<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Movimientos</title>
    <style>
        /* Estilos CSS para el PDF */
        @font-face {
            font-family: 'Figtree';
            src: url('path-to-figtree-font/Figtree-Regular.ttf') format('truetype');
            font-weight: 400;
        }

        @font-face {
            font-family: 'Figtree';
            src: url('path-to-figtree-font/Figtree-Medium.ttf') format('truetype');
            font-weight: 500;
        }

        @font-face {
            font-family: 'Figtree';
            src: url('path-to-figtree-font/Figtree-SemiBold.ttf') format('truetype');
            font-weight: 600;
        }

        body {
            font-family: 'Figtree', Arial, sans-serif;
            margin: 20px;
            font-size: 11px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #4a4a4a;
            font-weight: 500;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            color: #333;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Reporte de Movimientos</h1>
        
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
                            <td>
                                @if($resultado->personal)
                                    {{ $resultado->personal->persona->nombre }}
                                    {{ $resultado->personal->persona->apellidopaterno }}
                                    {{ $resultado->personal->persona->apellidomaterno }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
    </div>
    <div class="footer">
        Generado el {{ now()->format('d/m/Y') }}
    </div>
</body>

</html>