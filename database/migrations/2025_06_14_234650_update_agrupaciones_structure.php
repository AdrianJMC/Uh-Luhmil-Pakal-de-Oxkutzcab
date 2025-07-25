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
        Schema::table('agrupaciones', function (Blueprint $table) {
            // Eliminar columnas antiguas
            $table->dropColumn([
                'nombre',
                'edad',
                'nacionalidad',
                'ubicacion',
                'curp',
                'rfc',
                'superficie_cosecha',
                'nombre_representante',
                'email',
                'tipo_suelo',
                'created_at',
                'updated_at',
            ]);

            // Agregar nuevas columnas
            $table->string('nombre_agrupacion')->nullable();
            $table->string('nombre_representante')->nullable();
            $table->string('email_representante')->unique()->nullable();
            $table->string('curp_representante')->nullable();
            $table->string('rfc_agrupacion')->nullable();
            $table->string('direccion_agrupacion')->nullable();
            $table->decimal('superficie_cosecha', 8, 2)->nullable();
            $table->string('tipo_suelo')->nullable();
            $table->integer('num_trabajadores')->nullable();
            $table->string('tipo_maquinaria')->nullable();
            $table->integer('horas_trabajo')->nullable();
            $table->string('certificaciones')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_cosecha')->nullable();
            $table->string('estado')->default('pendiente');
            $table->timestamps(); // Volvemos a agregar timestamps actualizados
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agrupaciones', function (Blueprint $table) {
            // Aquí puedes revertir si es necesario, aunque puede ser complicado
        });
    }
};
