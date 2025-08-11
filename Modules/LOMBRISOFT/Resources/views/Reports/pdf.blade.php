<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Actividades</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #eee; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<h2>Reporte de Actividades</h2>

<table>
    <thead>
        <tr>
            <th>Cama</th>
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Hora</th>
            @if($columnas['feeding']) <th>Alimento</th> <th>Cantidad (kg)</th> @endif
            @if($columnas['moisture']) <th>Nivel Humedad (%)</th> @endif
            @if($columnas['harvest']) <th>Peso Cosecha (kg)</th> <th>Producto</th> @endif
            @if($columnas['ph']) <th>PH</th> @endif
            @if($columnas['temperature']) <th>Temperatura (°C)</th> @endif
        </tr>
    </thead>
    <tbody>
        @foreach($actividades as $actividad)
            <tr>
                {{-- Cama --}}
                <td>{{ $actividad->wormBed->number ?? 'Sin número' }}</td>

                {{-- Tipo, Descripción, Fecha, Hora --}}
                <td>{{ ucfirst($actividad->tipo) }}</td>
                <td>{{ $actividad->descripcion ?? '-' }}</td>
                <td>{{ $actividad->fecha_actividad }}</td>
                <td>{{ $actividad->hora_actividad }}</td>

                {{-- Alimentación --}}
                @if($columnas['feeding'])
                    <td>{{ $actividad->feeding->tipo_alimento ?? '-' }}</td>
                    <td>{{ $actividad->feeding->cantidad_alimento ?? '-' }}</td>
                @endif

                {{-- Humedad --}}
                @if($columnas['moisture'])
                    <td>{{ $actividad->moisture->nivel_humedad ?? '-' }}</td>
                @endif

                {{-- Recolección --}}
                @if($columnas['harvest'])
                    <td>{{ $actividad->harvest->peso_cosechado ?? '-' }}</td>
                    <td>{{ $actividad->harvest->producto ?? '-' }}</td>
                @endif

                {{-- PH --}}
                @if($columnas['ph'])
                    <td>{{ $actividad->ph->valor ?? '-' }}</td>
                @endif

                {{-- Temperatura --}}
                @if($columnas['temperature'])
                    <td>{{ $actividad->temperature->valor ?? '-' }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
