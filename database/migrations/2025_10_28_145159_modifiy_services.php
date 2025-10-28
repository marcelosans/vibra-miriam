<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Quitar la clave primaria actual (nombre)
            DB::statement('ALTER TABLE services DROP PRIMARY KEY');

            // Agregar la nueva columna id autoincremental como clave primaria
            $table->id()->first();

            // Hacer que nombre sea único para no repetirse
            $table->unique('nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Quitar el id y restaurar 'nombre' como primary key
            $table->dropUnique(['nombre']);
            $table->dropColumn('id');

            DB::statement('ALTER TABLE services ADD PRIMARY KEY (nombre)');
        });
    }
};