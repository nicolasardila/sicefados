<?php 
namespace Modules\LOMBRISOFT\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\LOMBRISOFT\Entities\BedActivity;
use Modules\LOMBRISOFT\Entities\WormBed;
use Modules\LOMBRISOFT\Entities\FeedingActivity;
use Modules\LOMBRISOFT\Entities\MoistureActivity;
use Modules\LOMBRISOFT\Entities\HarvestActivity;
use Modules\LOMBRISOFT\Entities\PhActivity;
use Modules\LOMBRISOFT\Entities\TemperatureActivity;
use DB;

class BedActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = BedActivity::with([
    'wormBed',
    'feeding',
    'moisture',
    'harvest',
    'ph',
    'temperature'
]);


        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_actividad', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_actividad', '<=', $request->fecha_fin);
        }

        if ($request->filled('cama_id')) {
            $query->where('worm_bed_id', $request->cama_id);
        }

        $activities = $query->orderBy('fecha_actividad', 'desc')->get();
        $camas = WormBed::all();

        return view('lombrisoft::bed_activities.index', compact('activities', 'camas'));
    }

    public function create()
    {
        $camas = WormBed::all();
        return view('lombrisoft::bed_activities.create', compact('camas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'worm_bed_id' => 'required|exists:wormsBeds,id',
            'tipo' => 'required|in:mantenimiento,alimentacion,humedad,recoleccion,ph,temperatura',
            'fecha_actividad' => 'required|date',
        ]);

        // Validaciones específicas
        switch ($request->tipo) {
            case 'alimentacion':
                $request->validate([
                    'cantidad_alimento' => 'required|integer|min:1',
                    'tipo_alimento' => 'required|string|max:255',
                ]);
                break;

            case 'humedad':
                $request->validate([
                    'nivel_humedad' => 'required|numeric|min:0|max:100',
                ]);
                break;

            case 'recoleccion':
                $request->validate([
                    'tipo_recoleccion' => 'required|in:humus,lixiviado',
                    'cantidad_recolectada' => 'required|integer|min:1',
                ]);
                break;

            case 'ph':
                $request->validate([
                    'ph' => 'required|numeric|min:0|max:14',
                ]);
                break;

            case 'temperatura':
                $request->validate([
                    'temperatura' => 'required|numeric|min:-50|max:50',
                ]);
                break;
        }

        DB::beginTransaction();

        try {
            // 1. Guardar actividad general
            $actividad = BedActivity::create([
                'worm_bed_id' => $request->worm_bed_id,
                'tipo' => $request->tipo,
                'descripcion' => $request->descripcion,
                'fecha_actividad' => $request->fecha_actividad,
                'hora_actividad' => $request->hora_actividad,
            ]);

            // 2. Guardar datos específicos según tipo
            switch ($request->tipo) {
                case 'alimentacion':
                    FeedingActivity::create([
                        'bed_activity_id' => $actividad->id,
                        'cantidad_alimento' => $request->cantidad_alimento,
                        'tipo_alimento' => $request->tipo_alimento,
                    ]);
                    break;

                case 'humedad':
                    MoistureActivity::create([
                        'bed_activity_id' => $actividad->id,
                        'nivel_humedad' => $request->nivel_humedad,
                    ]);
                    break;

                case 'recoleccion':
                    HarvestActivity::create([
                        'bed_activity_id' => $actividad->id,
                        'tipo_recoleccion' => $request->tipo_recoleccion,
                        'cantidad_recolectada' => $request->cantidad_recolectada,
                    ]);
                    break;

                case 'ph':
                    PhActivity::create([
                        'bed_activity_id' => $actividad->id,
                        'ph' => $request->ph,
                    ]);
                    break;

                case 'temperatura':
                    TemperatureActivity::create([
                        'bed_activity_id' => $actividad->id,
                        'temperatura' => $request->temperatura,
                    ]);
                    break;
            }

            DB::commit();

            return redirect()->route('lombrisoft.admin.bed_activities.index')->with('success', 'Actividad registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function show($id)
{
    $activity = BedActivity::with([
        'wormBed',
        'feeding',
        'moisture',
        'harvest',
        'ph',
        'temperature'
    ])->findOrFail($id);

    return view('lombrisoft::bed_activities.show', compact('activity'));
}


    public function update(Request $request, $id)
{
    $actividad = BedActivity::findOrFail($id);

    // Actualizar la actividad base
    $actividad->update([
        'worm_bed_id' => $request->worm_bed_id,
        'tipo' => $request->tipo,
        'descripcion' => $request->descripcion,
        'fecha_actividad' => $request->fecha_actividad,
        'hora_actividad' => $request->hora_actividad,
    ]);

    // Actualizar la tabla hija según el tipo
    switch ($actividad->tipo) {
        case 'alimentacion':
            $actividad->feeding()->updateOrCreate(
                ['bed_activity_id' => $actividad->id],
                [
                    'cantidad_alimento' => $request->cantidad_alimento,
                    'tipo_alimento' => $request->tipo_alimento
                ]
            );
            break;

        case 'recoleccion':
            $actividad->harvest()->updateOrCreate(
                ['bed_activity_id' => $actividad->id],
                [
                    'tipo_recoleccion' => $request->tipo_recoleccion,
                    'cantidad_recolectada' => $request->cantidad_recolectada
                ]
            );
            break;

        case 'ph':
            $actividad->ph()->updateOrCreate(
                ['bed_activity_id' => $actividad->id],
                ['ph' => $request->ph]
            );
            break;

        case 'temperatura':
            $actividad->temperature()->updateOrCreate(
                ['bed_activity_id' => $actividad->id],
                ['temperatura' => $request->temperatura]
            );
            break;

        case 'humedad':
            $actividad->moisture()->updateOrCreate(
                ['bed_activity_id' => $actividad->id],
                ['nivel_humedad' => $request->nivel_humedad]
            );
            break;
    }

    return redirect()
        ->route('lombrisoft.admin.bed_activities.index')
        ->with('success', 'Actividad actualizada correctamente');
}


    public function destroy($id)
    {
        $actividad = BedActivity::findOrFail($id);
        $actividad->delete();

        return redirect()->route('lombrisoft.admin.bed_activities.index')->with('success', 'Actividad eliminada correctamente.');
    }
}
