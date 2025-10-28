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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Clave foránea al modelo User
            $table->date('appointment_date'); // Para guardar el día de la cita
            $table->time('appointment_time'); // Para guardar la hora de la cita
            $table->enum('status', ['pendiente', 'confirmado', 'cancelado'])->default('pendiente'); // Estado de la cita
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

