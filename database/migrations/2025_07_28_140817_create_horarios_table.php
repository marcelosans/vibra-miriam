<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
             
            // Día de la semana por nombre
            $table->string('dia_de_la_semana')->primary();
            $table->time('horario_ini_manana')->nullable();
            $table->time('horario_final_manana')->nullable();
            $table->time('horario_ini_tarde')->nullable();
            $table->time('horario_final_tarde')->nullable();
            $table->boolean('laborable')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
