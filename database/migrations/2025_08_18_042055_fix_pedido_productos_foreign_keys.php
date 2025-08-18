<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Asegura que las tablas padre existen primero
        foreach (['pedidos','productos','agrupaciones'] as $t) {
            if (!Schema::hasTable($t)) return;
            DB::statement("ALTER TABLE `{$t}` ENGINE=InnoDB");
        }

        if (Schema::hasTable('pedido_productos')) {
            Schema::drop('pedido_productos');
        }

        Schema::create('pedido_productos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->foreignId('agrupacion_id')->constrained('agrupaciones')->cascadeOnDelete();

            $table->decimal('cantidad', 8, 2);
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido_productos');
    }
};
