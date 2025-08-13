<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('agrupaciones', function (Blueprint $table) {
            // Cambia de VARCHAR(255) a TEXT
            $table->text('tipo_maquinaria')->change();
            // Si la columna era nullable antes, usa:
            // $table->text('tipo_maquinaria')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('agrupaciones', function (Blueprint $table) {
            // Revertir a VARCHAR(255) si hicieras rollback
            $table->string('tipo_maquinaria', 255)->change();
            // Si era nullable:
            // $table->string('tipo_maquinaria', 255)->nullable()->change();
        });
    }
};
