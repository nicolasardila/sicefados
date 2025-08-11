@extends('lombrisoft::layouts.master')

@section('content')
<div class="container mt-5">
    <div class="mb-3 text-end">
        <a href="{{ route('lombrisoft.admin.bed_activities.create') }}" class="btn btn-primary">Registrar Nueva Actividad</a>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    @if ($activities->isEmpty())
    <div class="alert alert-info text-center">No hay actividades registradas.</div>
    @else
    <div class="card shadow-lg rounded">
        <div class="card-header bg-success text-white text-center">
            <h4>Listado de Actividades</h4>
        </div>
        <div class="card shadow-lg rounded mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Filtrar Actividades</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('lombrisoft.admin.bed_activities.index') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <label for="filter_tipo" class="form-label">Tipo de Actividad</label>
                    <select class="form-select" id="filter_tipo" name="tipo">
                        <option value="">Todos los tipos</option>
                        <option value="mantenimiento" {{ request('tipo') == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                        <option value="alimentacion" {{ request('tipo') == 'alimentacion' ? 'selected' : '' }}>Alimentación</option>
                        <option value="humedad" {{ request('tipo') == 'humedad' ? 'selected' : '' }}>Humedad</option>
                        <option value="recoleccion" {{ request('tipo') == 'recoleccion' ? 'selected' : '' }}>Recolección</option>
                        <option value="ph" {{ request('tipo') == 'ph' ? 'selected' : '' }}>pH</option>
                        <option value="temperatura" {{ request('tipo') == 'temperatura' ? 'selected' : '' }}>Temperatura</option>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label for="filter_fecha_inicio" class="form-label">Fecha desde</label>
                    <input type="date" class="form-control" id="filter_fecha_inicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                </div>
                
                <div class="col-md-4">
                    <label for="filter_fecha_fin" class="form-label">Fecha hasta</label>
                    <input type="date" class="form-control" id="filter_fecha_fin" name="fecha_fin" value="{{ request('fecha_fin') }}">
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('lombrisoft.admin.bed_activities.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Cama</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                        <tr>
                            <td>Cama N° {{ $activity->wormBed->number }}</td>
                            <td>{{ ucfirst($activity->tipo) }}</td>
                            <td>{{ $activity->fecha_actividad }}</td>
                            <td>{{ $activity->hora_actividad ?? '-' }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editModal"
                                data-id="{{ $activity->id }}"
                                data-tipo="{{ $activity->tipo }}"
                                data-cama="{{ $activity->worm_bed_id }}"
                                data-fecha="{{ $activity->fecha_actividad }}"
                                data-hora="{{ $activity->hora_actividad }}"
                                data-descripcion="{{ $activity->descripcion ?? '' }}"
                                data-cantidad-alimento="{{ $activity->feeding->cantidad_alimento ?? '' }}"
                                data-tipo-alimento="{{ $activity->feeding->tipo_alimento ?? '' }}"
                                data-nivel-humedad="{{ $activity->moisture->nivel_humedad ?? '' }}"
                                data-tipo-recoleccion="{{ $activity->harvest->tipo_recoleccion ?? '' }}"
                                data-cantidad-recolectada="{{ $activity->harvest->cantidad_recolectada ?? '' }}"
                                data-ph="{{ $activity->ph->ph ?? '' }}"
                                data-temperatura="{{ $activity->temperature->temperatura ?? '' }}">
                                Editar
                            </button>
                                <form action="{{ route('lombrisoft.admin.bed_activities.destroy', $activity->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmarEliminacion(this)">Eliminar</button>
                                </form>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal"
    data-id="{{ $activity->id }}"
    data-tipo="{{ $activity->tipo }}"
    data-cama="Cama N° {{ $activity->wormBed->number }}"
    data-fecha="{{ $activity->fecha_actividad }}"
    data-hora="{{ $activity->hora_actividad }}"
    data-descripcion="{{ $activity->descripcion ?? 'Sin descripción' }}"
    data-cantidad-alimento="{{ $activity->feeding->cantidad_alimento ?? 'N/A' }}"
    data-tipo-alimento="{{ $activity->feeding->tipo_alimento ?? 'N/A' }}"
    data-nivel-humedad="{{ $activity->moisture->nivel_humedad ?? 'N/A' }}"
    data-tipo-recoleccion="{{ $activity->harvest->tipo_recoleccion ?? 'N/A' }}"
    data-cantidad-recolectada="{{ $activity->harvest->cantidad_recolectada ?? 'N/A' }}"
    data-ph="{{ optional($activity->ph)->ph ?? 'N/A' }}"
    data-temperatura="{{ $activity->temperature->temperatura ?? 'N/A' }}">
    <i class="fas fa-eye"></i> Ver
</button>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
<!-- Modal de Visualización -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewModalLabel">Detalles Completos de la Actividad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Información Básica</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Cama:</strong> <span id="viewCama"></span></li>
                            <li class="list-group-item"><strong>Tipo:</strong> <span id="viewTipo"></span></li>
                            <li class="list-group-item"><strong>Fecha:</strong> <span id="viewFecha"></span></li>
                            <li class="list-group-item"><strong>Hora:</strong> <span id="viewHora"></span></li>
                        </ul>
                    </div><div class="col-md-6">
    <h5 class="mb-3">Detalles Específicos</h5>
                <ul class="list-group list-group-flush" id="specificDetails">
                    <!-- Aquí se insertan los detalles dinámicamente -->
                </ul>
</div>


                </div>
                <div class="mt-4">
                    <h5>Descripción</h5>
                    <div class="card">
                        <div class="card-body">
                            <p id="viewDescripcion" class="mb-0"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal edición -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" id="editForm" action="{{ route('lombrisoft.admin.bed_activities.update', ['id' => '__ID__']) }}">

                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Actividad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <!-- Campos comunes -->
                    <div class="mb-3">
                        <label for="editWormBed" class="form-label">Cama</label>
                        <select class="form-select" id="editWormBed" name="worm_bed_id" required>
                            @foreach ($camas as $cama)
                            <option value="{{ $cama->id }}">Cama N° {{ $cama->number }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editTipo" class="form-label">Tipo de Actividad</label>
                        <select class="form-select" id="editTipo" name="tipo" required>
                            <option value="mantenimiento">Mantenimiento</option>
                            <option value="alimentacion">Alimentación</option>
                            <option value="humedad">Humedad</option>
                            <option value="recoleccion">Recolección</option>
                            <option value="ph">Ph</option>
                            <option value="temperatura">Temperatura</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editFecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="editFecha" name="fecha_actividad" required>
                    </div>

                    <div class="mb-3">
                        <label for="editHora" class="form-label">Hora</label>
                        <input type="time" class="form-control" id="editHora" name="hora_actividad">
                    </div>

                    <!-- Campo descripción (siempre visible) -->
                    <div class="mb-3">
                        <label for="editDescripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="editDescripcion" name="descripcion" rows="2"></textarea>
                    </div>

                    <!-- Campos específicos por tipo (ocultos inicialmente) -->
                    <div class="mb-3 tipo-campo" data-tipo="alimentacion" style="display: none;">
                        <label for="editCantidadAlimento" class="form-label">Cantidad de Alimento (kg)</label>
                        <input type="number" class="form-control" id="editCantidadAlimento" name="cantidad_alimento" min="1">
                    </div>

                    <div class="mb-3 tipo-campo" data-tipo="alimentacion" style="display: none;">
                        <label for="editTipoAlimento" class="form-label">Tipo de Alimento</label>
                        <input type="text" class="form-control" id="editTipoAlimento" name="tipo_alimento">
                    </div>

                    <div class="mb-3 tipo-campo" data-tipo="humedad" style="display: none;">
                        <label for="editNivelHumedad" class="form-label">Nivel de Humedad (%)</label>
                        <input type="number" step="0.1" class="form-control" id="editNivelHumedad" name="nivel_humedad" min="0" max="100">
                    </div>

                    <div class="mb-3 tipo-campo" data-tipo="recoleccion" style="display: none;">
                        <label for="editTipoRecoleccion" class="form-label">Tipo de Recolección</label>
                        <select class="form-select" id="editTipoRecoleccion" name="tipo_recoleccion">
                            <option value="" selected disabled>Seleccione tipo de recolección</option>
                            <option value="humus">Humus</option>
                            <option value="lixiviado">Lixiviado</option>
                        </select>
                    </div>

                    <div class="mb-3 tipo-campo" data-tipo="recoleccion" style="display: none;">
                        <label for="editCantidadRecolectada" class="form-label">Cantidad Recolectada</label>
                        <input type="number" class="form-control" id="editCantidadRecolectada" name="cantidad_recolectada" min="1">
                    </div>

                    <div class="mb-3 tipo-campo" data-tipo="ph" style="display: none;">
                        <label for="editPh" class="form-label">Nivel de pH</label>
                        <input type="number" step="0.1" class="form-control" id="editPh" name="ph" min="0" max="14">
                    </div>

                    <div class="mb-3 tipo-campo" data-tipo="temperatura" style="display: none;">
                        <label for="editTemperatura" class="form-label">Temperatura (°C)</label>
                        <input type="number" step="0.1" class="form-control" id="editTemperatura" name="temperatura" min="-50" max="100">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const baseUpdateUrl = "{{ url('admin/bed_activities') }}"; // O la ruta real a tu controlador

    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('editModal');
        
        // Función para mostrar/ocultar campos según el tipo de actividad
        function actualizarCampos(tipo) {
            // Ocultar todos los campos específicos primero
            document.querySelectorAll('.tipo-campo').forEach(campo => {
                campo.style.display = 'none';
            });
            
            // Mostrar solo los campos correspondientes al tipo seleccionado
            document.querySelectorAll(`.tipo-campo[data-tipo="${tipo}"]`).forEach(campo => {
                campo.style.display = 'block';
            });
        }
        
        // Evento cuando se abre el modal
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const tipo = button.getAttribute('data-tipo');
            const cama = button.getAttribute('data-cama');
            const fecha = button.getAttribute('data-fecha');
            const hora = button.getAttribute('data-hora');
            const descripcion = button.getAttribute('data-descripcion') || '';

            // Obtener todos los datos específicos de la actividad
            const cantidadAlimento = button.getAttribute('data-cantidad-alimento') || '';
            const tipoAlimento = button.getAttribute('data-tipo-alimento') || '';
            const nivelHumedad = button.getAttribute('data-nivel-humedad') || '';
            const tipoRecoleccion = button.getAttribute('data-tipo-recoleccion') || '';
            const cantidadRecolectada = button.getAttribute('data-cantidad-recolectada') || '';
            const ph = button.getAttribute('data-ph') || '';
            const temperatura = button.getAttribute('data-temperatura') || '';

            // Actualizar el formulario con la ruta correcta
            const form = document.getElementById('editForm');
           form.action = form.action.replace('__ID__', id);


            // Establecer los valores comunes
            document.getElementById('editWormBed').value = cama;
            document.getElementById('editTipo').value = tipo;
            document.getElementById('editFecha').value = fecha;
            document.getElementById('editHora').value = hora;
            document.getElementById('editDescripcion').value = descripcion;

            // Establecer los valores específicos
            document.getElementById('editCantidadAlimento').value = cantidadAlimento;
            document.getElementById('editTipoAlimento').value = tipoAlimento;
            document.getElementById('editNivelHumedad').value = nivelHumedad;
            document.getElementById('editTipoRecoleccion').value = tipoRecoleccion;
            document.getElementById('editCantidadRecolectada').value = cantidadRecolectada;
            document.getElementById('editPh').value = ph;
            document.getElementById('editTemperatura').value = temperatura;

            // Actualizar campos visibles según el tipo
            actualizarCampos(tipo);
        });
        
        // Evento cuando cambia el tipo de actividad
        document.getElementById('editTipo').addEventListener('change', function() {
            actualizarCampos(this.value);
        });
    });

    function confirmarEliminacion(element) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                element.closest('form').submit();
            }
        });
    }
    // Modal de Visualización
// Modal de Visualización
document.getElementById('viewModal').addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const tipo = button.getAttribute('data-tipo');
    
    // Establecer valores básicos
    document.getElementById('viewCama').textContent = button.getAttribute('data-cama');
    document.getElementById('viewTipo').textContent = button.getAttribute('data-tipo');
    document.getElementById('viewFecha').textContent = button.getAttribute('data-fecha');
    document.getElementById('viewHora').textContent = button.getAttribute('data-hora') || 'No registrada';
    document.getElementById('viewDescripcion').textContent = button.getAttribute('data-descripcion');

    // Generar detalles específicos según el tipo
    const detailsContainer = document.getElementById('specificDetails');
    detailsContainer.innerHTML = ''; // Limpiar contenido anterior

    const tipoMap = {
        'alimentacion': [
            { label: 'Cantidad Alimento', value: button.getAttribute('data-cantidad-alimento'), unit: 'kg' },
            { label: 'Tipo Alimento', value: button.getAttribute('data-tipo-alimento') }
        ],
        'humedad': [
            { label: 'Nivel Humedad', value: button.getAttribute('data-nivel-humedad'), unit: '%' }
        ],
        'recoleccion': [
            { label: 'Tipo Recolección', value: button.getAttribute('data-tipo-recoleccion') },
            { label: 'Cantidad Recolectada', value: button.getAttribute('data-cantidad-recolectada'), unit: 'kg' }
        ],
        'ph': [
            { label: 'Nivel de pH', value: button.getAttribute('data-ph') }
        ],
        'temperatura': [
            { label: 'Temperatura', value: button.getAttribute('data-temperatura'), unit: '°C' }
        ],
        'mantenimiento': [
            { label: 'Actividad', value: 'Mantenimiento general' }
        ]
    };

    const detalles = tipoMap[tipo] || [];
    
    detalles.forEach(detalle => {
        if (detalle.value && detalle.value !== 'N/A') {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.innerHTML = `<strong>${detalle.label}:</strong> ${detalle.value} ${detalle.unit || ''}`;
            detailsContainer.appendChild(listItem);
        }
    });

    // Si no hay detalles específicos
    if (detailsContainer.children.length === 0) {
        const listItem = document.createElement('li');
        listItem.className = 'list-group-item text-muted';
        listItem.textContent = 'No hay detalles específicos registrados';
        detailsContainer.appendChild(listItem);
    }
});
</script>
@endsection