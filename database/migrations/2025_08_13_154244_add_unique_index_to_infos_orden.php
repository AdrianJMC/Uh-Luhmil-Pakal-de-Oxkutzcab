<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Asegúrate primero de que no existan duplicados antes de correr esto
        Schema::table('infos', function (Blueprint $table) {
            $table->unique('orden');
        });
    }

    public function down(): void
    {
        Schema::table('infos', function (Blueprint $table) {
            $table->dropUnique(['orden']);
        });
    }
};
