<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCertificacionesToTextInAgrupacionesTable extends Migration
{
    public function up()
    {
        Schema::table('agrupaciones', function (Blueprint $table) {
            $table->text('certificaciones')->change();
        });
    }

    public function down()
    {
        Schema::table('agrupaciones', function (Blueprint $table) {
            $table->string('certificaciones', 255)->change();
        });
    }
}
