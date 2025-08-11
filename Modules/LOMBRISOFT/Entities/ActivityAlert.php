<?php

namespace Modules\LOMBRISOFT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityAlert extends Model
{
    protected $fillable = [
        'worm_bed_id',
        'activity_type',
        'frequency_days',
        'warning_days',
        'is_active',
        'last_execution',
        'next_expected'
    ];
    
    protected $dates = ['last_execution', 'next_expected'];
    
    protected $casts = [
        'is_active' => 'boolean'
    ];
    
    // Relación con la cama
    public function wormBed()
    {
        return $this->belongsTo(WormBed::class);
    }
    
    // Método para verificar si está vencida
    public function isOverdue()
    {
        if (!$this->next_expected) return false;
        
        return now()->greaterThan($this->next_expected);
    }
    
    // Método para verificar si está próxima a vencer
    public function isUpcoming()
    {
        if (!$this->next_expected) return false;
        
        $warningDate = $this->next_expected->subDays($this->warning_days);
        return now()->greaterThanOrEqualTo($warningDate) && 
               now()->lessThan($this->next_expected);
    }
    
    // Actualizar fechas después de una actividad
    public function updateAfterActivity()
    {
        $this->update([
            'last_execution' => now(),
            'next_expected' => now()->addDays($this->frequency_days)
        ]);
    }
}
