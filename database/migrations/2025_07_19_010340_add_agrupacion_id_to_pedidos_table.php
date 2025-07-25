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
        Schema::table('pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('agrupacion_id')->nullable()->after('id');

            $table->foreign('agrupacion_id')
                ->references('id')
                ->on('agrupaciones')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign(['agrupacion_id']);
            $table->dropColumn('agrupacion_id');
        });
    }
};
