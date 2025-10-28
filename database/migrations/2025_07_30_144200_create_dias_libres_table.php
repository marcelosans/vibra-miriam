<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dias_libres', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->unique(); // Día bloqueado
            $table->string('motivo')->nullable(); // Opcional: motivo del bloqueo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dias_libres');
    }
};
