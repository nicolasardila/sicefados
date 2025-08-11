@extends('lombrisoft::layouts.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white text-center">
            <h4>Configurar Nueva Alerta de Actividad</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('lombrisoft.admin.activity_alerts.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="worm_bed_id" class="form-label">Cama</label>
                            <select class="form-select" id="worm_bed_id" name="worm_bed_id" required>
                                <option value="" disabled selected>Seleccione una cama</option>
                                @foreach ($wormBeds as $cama)
                                    <option value="{{ $cama->id }}" {{ old('worm_bed_id') == $cama->id ? 'selected' : '' }}>
                                        Cama N° {{ $cama->number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="activity_type" class="form-label">Tipo de Actividad</label>
                            <select class="form-select" id="activity_type" name="activity_type" required>
                                <option value="" disabled selected>Seleccione un tipo</option>
                                @foreach($activityTypes as $key => $value)
                                    <option value="{{ $key }}" {{ old('activity_type') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="frequency_days" class="form-label">Frecuencia (días)</label>
                            <input type="number" class="form-control" id="frequency_days" 
                                   name="frequency_days" min="1" required
                                   value="{{ old('frequency_days') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="warning_days" class="form-label">Días de advertencia previa</label>
                            <input type="number" class="form-control" id="warning_days" 
                                   name="warning_days" min="0" required
                                   value="{{ old('warning_days') }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" 
                           name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Alerta activa</label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Guardar Alerta</button>
                    <a href="{{ route('lombrisoft.admin.activity_alerts.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación para que warning_days no sea mayor que frequency_days
    const frequencyInput = document.getElementById('frequency_days');
    const warningInput = document.getElementById('warning_days');
    
    function validateWarningDays() {
        if (parseInt(warningInput.value) > parseInt(frequencyInput.value)) {
            warningInput.setCustomValidity('Los días de advertencia no pueden ser mayores que la frecuencia');
        } else {
            warningInput.setCustomValidity('');
        }
    }
    
    frequencyInput.addEventListener('change', validateWarningDays);
    warningInput.addEventListener('change', validateWarningDays);
});
</script>
@endsection