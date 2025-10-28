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
        Schema::table('reservations', function (Blueprint $table) {
            // Modificar el enum para incluir 'finalizado'
            $table->enum('status', ['pendiente', 'confirmado', 'cancelado', 'finalizado'])
                  ->default('pendiente')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Revertir al enum original sin 'finalizado'
            $table->enum('status', ['pendiente', 'confirmado', 'cancelado'])
                  ->default('pendiente')
                  ->change();
        });
    }
};