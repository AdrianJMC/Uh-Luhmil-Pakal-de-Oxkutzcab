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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            // Relación con agrupaciones
            $table->unsignedBigInteger('agrupacion_id');
            $table->foreign('agrupacion_id')->references('id')->on('agrupaciones')->onDelete('cascade');

            // Datos del producto
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('categoria')->nullable(); // opcional: puedes usar tabla relacionada si lo deseas
            $table->decimal('precio', 10, 2)->nullable(); // precio unitario
            $table->integer('stock')->nullable();         // cantidad disponible
            $table->string('unidad')->nullable();         // ej. kg, pieza, caja
            $table->string('imagen')->nullable();         // ruta a la imagen

            // Estado de revisión
            $table->enum('estado', ['pendiente_aprobacion', 'aprobado', 'rechazado'])->default('pendiente_aprobacion');
            $table->text('motivo_rechazo')->nullable();   // si es rechazado, se guarda el motivo

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
