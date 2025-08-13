<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // nombre -> nombre_agrupacion
        if (Schema::hasColumn('agrupaciones', 'nombre') && !Schema::hasColumn('agrupaciones', 'nombre_agrupacion')) {
            Schema::table('agrupaciones', fn(Blueprint $t) => $t->renameColumn('nombre', 'nombre_agrupacion'));
        }

        // email -> email_representante
        if (Schema::hasColumn('agrupaciones', 'email') && !Schema::hasColumn('agrupaciones', 'email_representante')) {
            Schema::table('agrupaciones', fn(Blueprint $t) => $t->renameColumn('email', 'email_representante'));
        }

        // curp -> curp_representante
        if (Schema::hasColumn('agrupaciones', 'curp') && !Schema::hasColumn('agrupaciones', 'curp_representante')) {
            Schema::table('agrupaciones', fn(Blueprint $t) => $t->renameColumn('curp', 'curp_representante'));
        }

        // rfc -> rfc_agrupacion
        if (Schema::hasColumn('agrupaciones', 'rfc') && !Schema::hasColumn('agrupaciones', 'rfc_agrupacion')) {
            Schema::table('agrupaciones', fn(Blueprint $t) => $t->renameColumn('rfc', 'rfc_agrupacion'));
        }

        // Si por alguna razón quedaron ambas columnas (vieja y nueva),
        // copia datos faltantes y elimina la vieja.
        $pairs = [
            ['old' => 'nombre', 'new' => 'nombre_agrupacion'],
            ['old' => 'email',  'new' => 'email_representante'],
            ['old' => 'curp',   'new' => 'curp_representante'],
            ['old' => 'rfc',    'new' => 'rfc_agrupacion'],
        ];

        foreach ($pairs as $p) {
            if (Schema::hasColumn('agrupaciones', $p['old']) && Schema::hasColumn('agrupaciones', $p['new'])) {
                DB::table('agrupaciones')
                    ->whereNull($p['new'])
                    ->update([$p['new'] => DB::raw($p['old'])]);

                Schema::table('agrupaciones', fn(Blueprint $t) => $t->dropColumn($p['old']));
            }
        }
    }

    public function down(): void
    {
        // Reversa mínima (opcional)
        if (!Schema::hasColumn('agrupaciones', 'curp') && Schema::hasColumn('agrupaciones', 'curp_representante')) {
            Schema::table('agrupaciones', fn(Blueprint $t) => $t->renameColumn('curp_representante', 'curp'));
        }
        if (!Schema::hasColumn('agrupaciones', 'rfc') && Schema::hasColumn('agrupaciones', 'rfc_agrupacion')) {
            Schema::table('agrupaciones', fn(Blueprint $t) => $t->renameColumn('rfc_agrupacion', 'rfc'));
        }
        if (!Schema::hasColumn('agrupaciones', 'email') && Schema::hasColumn('agrupaciones', 'email_representante')) {
            Schema::table('agrupaciones', fn(Blueprint $t) => $t->renameColumn('email_representante', 'email'));
        }
        if (!Schema::hasColumn('agrupaciones', 'nombre') && Schema::hasColumn('agrupaciones', 'nombre_agrupacion')) {
            Schema::table('agrupaciones', fn(Blueprint $t) => $t->renameColumn('nombre_agrupacion', 'nombre'));
        }
    }
};
