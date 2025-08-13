<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Si es SQLite, NO hagas drops: solo agrega columnas que falten
        if (DB::getDriverName() === 'sqlite') {
            Schema::table('agrupaciones', function (Blueprint $table) {
                if (!Schema::hasColumn('agrupaciones', 'nombre_agrupacion'))      $table->string('nombre_agrupacion')->nullable();
                if (!Schema::hasColumn('agrupaciones', 'nombre_representante'))   $table->string('nombre_representante')->nullable();
                if (!Schema::hasColumn('agrupaciones', 'email_representante'))    $table->string('email_representante')->unique()->nullable();
                if (!Schema::hasColumn('agrupaciones', 'curp_representante'))     $table->string('curp_representante')->nullable();
                if (!Schema::hasColumn('agrupaciones', 'rfc_agrupacion'))         $table->string('rfc_agrupacion')->nullable();
                if (!Schema::hasColumn('agrupaciones', 'direccion_agrupacion'))   $table->string('direccion_agrupacion')->nullable();
                if (!Schema::hasColumn('agrupaciones', 'superficie_cosecha'))     $table->decimal('superficie_cosecha', 8, 2)->nullable();
                if (!Schema::hasColumn('agrupaciones', 'tipo_suelo'))             $table->string('tipo_suelo')->nullable();
                if (!Schema::hasColumn('agrupaciones', 'num_trabajadores'))       $table->integer('num_trabajadores')->nullable();
                if (!Schema::hasColumn('agrupaciones', 'tipo_maquinaria'))        $table->string('tipo_maquinaria')->nullable();
                if (!Schema::hasColumn('agrupaciones', 'horas_trabajo'))          $table->integer('horas_trabajo')->nullable();
                if (!Schema::hasColumn('agrupaciones', 'certificaciones'))        $table->string('certificaciones')->nullable();
                if (!Schema::hasColumn('agrupaciones', 'fecha_inicio'))           $table->date('fecha_inicio')->nullable();
                if (!Schema::hasColumn('agrupaciones', 'fecha_cosecha'))          $table->date('fecha_cosecha')->nullable();
                if (!Schema::hasColumn('agrupaciones', 'estado'))                 $table->string('estado')->default('pendiente');

                // timestamps: agrega sólo si faltan
                if (!Schema::hasColumn('agrupaciones', 'created_at')) $table->timestamp('created_at')->nullable();
                if (!Schema::hasColumn('agrupaciones', 'updated_at')) $table->timestamp('updated_at')->nullable();
            });

            return; // <- importantísimo: NO sigas con drops en SQLite
        }

        // Para MySQL/Postgres (si alguna vez lo corres ahí), hazlo con guardas:
        Schema::table('agrupaciones', function (Blueprint $table) {
            // Borra índices únicos que apunten a columnas a dropear (ajusta nombres si no coinciden)
            try { $table->dropUnique('proveedores_curp_unique'); } catch (\Throwable $e) {}
            try { $table->dropUnique('agrupaciones_email_unique'); } catch (\Throwable $e) {}

            // Drop columna sólo si existe
            foreach ([
                'nombre','edad','nacionalidad','ubicacion','curp','rfc','superficie_cosecha',
                'nombre_representante','email','tipo_suelo','created_at','updated_at'
            ] as $col) {
                if (Schema::hasColumn('agrupaciones', $col)) {
                    $table->dropColumn($col);
                }
            }

            // Agrega nuevas (con guardas)
            if (!Schema::hasColumn('agrupaciones', 'nombre_agrupacion'))      $table->string('nombre_agrupacion')->nullable();
            if (!Schema::hasColumn('agrupaciones', 'nombre_representante'))   $table->string('nombre_representante')->nullable();
            if (!Schema::hasColumn('agrupaciones', 'email_representante'))    $table->string('email_representante')->unique()->nullable();
            if (!Schema::hasColumn('agrupaciones', 'curp_representante'))     $table->string('curp_representante')->nullable();
            if (!Schema::hasColumn('agrupaciones', 'rfc_agrupacion'))         $table->string('rfc_agrupacion')->nullable();
            if (!Schema::hasColumn('agrupaciones', 'direccion_agrupacion'))   $table->string('direccion_agrupacion')->nullable();
            if (!Schema::hasColumn('agrupaciones', 'superficie_cosecha'))     $table->decimal('superficie_cosecha', 8, 2)->nullable();
            if (!Schema::hasColumn('agrupaciones', 'tipo_suelo'))             $table->string('tipo_suelo')->nullable();
            if (!Schema::hasColumn('agrupaciones', 'num_trabajadores'))       $table->integer('num_trabajadores')->nullable();
            if (!Schema::hasColumn('agrupaciones', 'tipo_maquinaria'))        $table->string('tipo_maquinaria')->nullable();
            if (!Schema::hasColumn('agrupaciones', 'horas_trabajo'))          $table->integer('horas_trabajo')->nullable();
            if (!Schema::hasColumn('agrupaciones', 'certificaciones'))        $table->string('certificaciones')->nullable();
            if (!Schema::hasColumn('agrupaciones', 'fecha_inicio'))           $table->date('fecha_inicio')->nullable();
            if (!Schema::hasColumn('agrupaciones', 'fecha_cosecha'))          $table->date('fecha_cosecha')->nullable();
            if (!Schema::hasColumn('agrupaciones', 'estado'))                 $table->string('estado')->default('pendiente');

            if (!Schema::hasColumn('agrupaciones', 'created_at')) $table->timestamp('created_at')->nullable();
            if (!Schema::hasColumn('agrupaciones', 'updated_at')) $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        // Nada por ahora (o agrega reversa con guardas similares)
    }
};
