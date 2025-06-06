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
            // Para cambiar columnas existentes a nullable, usamos ->nullable()->change()
            $table->string('titulo')->nullable()->change();
            $table->text('texto')->nullable()->change();
            $table->string('imagen_ruta')->nullable()->change();
            $table->string('video_id')->nullable()->change();
            // Asegurarnos que 'orden' tenga default 0
            $table->integer('orden')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * Aquí revertimos a no-nullable (si lo deseas) y quitamos el default de 'orden'.
     */
    public function down()
    {
        Schema::table('infos', function (Blueprint $table) {
            // Si antes esas columnas NO admitían null, las revertimos a non-nullable:
            $table->string('titulo')->nullable(false)->change();
            $table->text('texto')->nullable(false)->change();
            $table->string('imagen_ruta')->nullable(false)->change();
            $table->string('video_id')->nullable(false)->change();
            // Revertimos `orden` para quitar el default (si era distinto antes)
            $table->integer('orden')->default(null)->change();
        });
    }
};
