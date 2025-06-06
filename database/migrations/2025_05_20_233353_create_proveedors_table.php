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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->unsignedTinyInteger('edad')->nullable();
            $table->string('nacionalidad', 50)->nullable();
            $table->string('curp', 18)->unique();
            $table->string('rfc', 13)->unique()->nullable();
            $table->string('ubicacion')->nullable();
            $table->decimal('superficie_cosecha', 8, 2)->nullable(); // en hectáreas
            $table->string('tipo_suelo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedors');
    }
};
