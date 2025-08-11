<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_alerts', function (Blueprint $table) {
            $table->id();
            
            // Relación con la cama
            $table->foreignId('worm_bed_id')
                ->constrained('wormsBeds')
                ->onDelete('cascade');
            
            // Tipo de actividad (debe coincidir con el enum de bed_activities)
            $table->enum('activity_type', [
                'mantenimiento', 
                'alimentacion', 
                'humedad', 
                'recoleccion', 
                'ph', 
                'temperatura'
            ]);
            
            // Configuración de alerta
            $table->integer('frequency_days')->default(1); // Frecuencia en días
            $table->integer('warning_days')->default(1); // Días antes para alerta temprana
            $table->boolean('is_active')->default(true);
            
            // Seguimiento
            $table->dateTime('last_execution')->nullable();
            $table->dateTime('next_expected')->nullable();
            
            $table->timestamps();
            
            // Índice compuesto para búsquedas eficientes
            $table->unique(['worm_bed_id', 'activity_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_alerts');
    }
}
