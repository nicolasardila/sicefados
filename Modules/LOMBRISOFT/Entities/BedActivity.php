<?php

namespace Modules\LOMBRISOFT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\LOMBRISOFT\Entities\WormBed;

class BedActivity extends Model
{
    protected $table = 'bed_activities';

    protected $fillable = [
        'worm_bed_id',
        'tipo',
        'descripcion',
        'fecha_actividad',
        'hora_actividad',
    ];

    /* ====================
       Relaciones
    ==================== */

    // Relación con la cama
    public function wormBed()
    {
        return $this->belongsTo(WormBed::class, 'worm_bed_id');
    }

    // Alimentación
    public function feeding()
    {
        return $this->hasOne(FeedingActivity::class, 'bed_activity_id');
    }

    // Humedad
    public function moisture()
    {
        return $this->hasOne(MoistureActivity::class, 'bed_activity_id');
    }

    // Recolección
    public function harvest()
    {
        return $this->hasOne(HarvestActivity::class, 'bed_activity_id');
    }

    // pH
    public function ph()
    {
        return $this->hasOne(PhActivity::class, 'bed_activity_id');
    }

    // Temperatura
    public function temperature()
    {
        return $this->hasOne(TemperatureActivity::class, 'bed_activity_id');
    }
}
