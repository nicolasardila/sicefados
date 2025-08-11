<?php

namespace Modules\LOMBRISOFT\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\LOMBRISOFT\Entities\ActivityAlert;
use Modules\LOMBRISOFT\Entities\WormBed;

class ActivityAlertController extends Controller
{
    /**
     * Display a listing of activity alerts.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $alerts = ActivityAlert::with('wormBed')
            ->orderBy('worm_bed_id')
            ->orderBy('activity_type')
            ->paginate(10); 

        $camas = WormBed::all(); // Obtener todas las camas para el filtro

        return view('lombrisoft::activity_alerts.index', compact('alerts', 'camas'));
    }

    /**
     * Show the form for creating a new activity alert.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $wormBeds = WormBed::all();
        $activityTypes = [
            'mantenimiento' => 'Mantenimiento',
            'alimentacion' => 'Alimentación',
            'humedad' => 'Control de Humedad',
            'recoleccion' => 'Recolección',
            'ph' => 'Control de pH',
            'temperatura' => 'Control de Temperatura'
        ];

        return view('lombrisoft::activity_alerts.create', compact('wormBeds', 'activityTypes'));
    }

    /**
     * Store a newly created activity alert.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'worm_bed_id' => 'required|exists:wormsBeds,id',
            'activity_type' => 'required|in:mantenimiento,alimentacion,humedad,recoleccion,ph,temperatura',
            'frequency_days' => 'required|integer|min:1',
            'warning_days' => 'required|integer|min:0|lte:frequency_days',
            'is_active' => 'sometimes|boolean'
        ]);

        // Verificar duplicados
        if (ActivityAlert::where('worm_bed_id', $validated['worm_bed_id'])
            ->where('activity_type', $validated['activity_type'])
            ->exists()
        ) {
            return back()->withErrors([
                'activity_type' => 'Ya existe una alerta para este tipo de actividad en la cama seleccionada'
            ])->withInput();
        }

        ActivityAlert::create($validated);

        return redirect()->route('lombrisoft.admin.activity_alerts.index')
            ->with('success', 'Alerta creada exitosamente');
    }

    /**
     * Display the specified activity alert.
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $alert = ActivityAlert::with('wormBed')->findOrFail($id);
        return view('lombrisoft::activity_alerts.show', compact('alert'));
    }

    /**
     * Show the form for editing the specified activity alert.
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $alert = ActivityAlert::findOrFail($id);
        $wormBeds = WormBed::all();
        $activityTypes = [
            'mantenimiento' => 'Mantenimiento',
            'alimentacion' => 'Alimentación',
            'humedad' => 'Control de Humedad',
            'recoleccion' => 'Recolección',
            'ph' => 'Control de pH',
            'temperatura' => 'Control de Temperatura'
        ];

        return view('lombrisoft::activity_alerts.edit', compact('alert', 'wormBeds', 'activityTypes'));
    }

    /**
     * Update the specified activity alert.
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $alert = ActivityAlert::findOrFail($id);

        $validated = $request->validate([
            'worm_bed_id' => 'required|exists:wormsBeds,id',
            'activity_type' => 'required|in:mantenimiento,alimentacion,humedad,recoleccion,ph,temperatura',
            'frequency_days' => 'required|integer|min:1',
            'warning_days' => 'required|integer|min:0|lte:frequency_days',
            'is_active' => 'sometimes|boolean',
            'last_execution' => 'nullable|date',
            'next_expected' => 'nullable|date'
        ]);

        // Verificar duplicados excluyendo el actual
        if (ActivityAlert::where('worm_bed_id', $validated['worm_bed_id'])
            ->where('activity_type', $validated['activity_type'])
            ->where('id', '!=', $id)
            ->exists()
        ) {
            return back()->withErrors([
                'activity_type' => 'Ya existe una alerta para este tipo de actividad en la cama seleccionada'
            ])->withInput();
        }

        $alert->update($validated);

        return redirect()->route('lombrisoft.admin.activity_alerts.index')
            ->with('success', 'Alerta actualizada exitosamente');
    }

    /**
     * Remove the specified activity alert.
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $alert = ActivityAlert::findOrFail($id);
        $alert->delete();

        return redirect()->route('lombrisoft.admin.activity_alerts.index')
            ->with('success', 'Alerta eliminada exitosamente');
    }
}
