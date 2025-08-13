<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Caso 1: solo existe 'nombre' -> renombrar
        if (Schema::hasColumn('agrupaciones', 'nombre') && !Schema::hasColumn('agrupaciones', 'nombre_agrupacion')) {
            Schema::table('agrupaciones', function (Blueprint $table) {
                $table->renameColumn('nombre', 'nombre_agrupacion');
            });
        }

        // Caso 2: existen ambas -> copiar y eliminar 'nombre'
        if (Schema::hasColumn('agrupaciones', 'nombre') && Schema::hasColumn('agrupaciones', 'nombre_agrupacion')) {
            // Copiar donde esté nulo
            DB::table('agrupaciones')
                ->whereNull('nombre_agrupacion')
                ->update(['nombre_agrupacion' => DB::raw('nombre')]);

            // Ahora eliminar 'nombre'
            Schema::table('agrupaciones', function (Blueprint $table) {
                $table->dropColumn('nombre');
            });
        }
    }

    public function down(): void
    {
        // Revertir: si no existe 'nombre' y sí 'nombre_agrupacion', volver atrás el nombre
        if (!Schema::hasColumn('agrupaciones', 'nombre') && Schema::hasColumn('agrupaciones', 'nombre_agrupacion')) {
            Schema::table('agrupaciones', function (Blueprint $table) {
                $table->renameColumn('nombre_agrupacion', 'nombre');
            });
        }
    }
};
