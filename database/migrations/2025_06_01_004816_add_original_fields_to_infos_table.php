<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('infos', function (Blueprint $table) {
            // Sólo agregamos las columnas faltantes. 
            // Si ya existen, el código ignora (evitamos colisión) usando hasColumn().

            if (! Schema::hasColumn('infos', 'titulo')) {
                $table->string('titulo')->nullable();
            }

            if (! Schema::hasColumn('infos', 'texto')) {
                $table->text('texto')->nullable();
            }

            if (! Schema::hasColumn('infos', 'imagen_ruta')) {
                $table->string('imagen_ruta')->nullable();
            }

            if (! Schema::hasColumn('infos', 'video_id')) {
                $table->string('video_id')->nullable();
            }

            if (! Schema::hasColumn('infos', 'orden')) {
                // Asumimos que originalmente era un entero con valor por defecto 0
                $table->integer('orden')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('infos', function (Blueprint $table) {
            // Para revertir, eliminamos exactamente esas columnas si existen.
            if (Schema::hasColumn('infos', 'titulo')) {
                $table->dropColumn('titulo');
            }
            if (Schema::hasColumn('infos', 'texto')) {
                $table->dropColumn('texto');
            }
            if (Schema::hasColumn('infos', 'imagen_ruta')) {
                $table->dropColumn('imagen_ruta');
            }
            if (Schema::hasColumn('infos', 'video_id')) {
                $table->dropColumn('video_id');
            }
            if (Schema::hasColumn('infos', 'orden')) {
                $table->dropColumn('orden');
            }
        });
    }
};
