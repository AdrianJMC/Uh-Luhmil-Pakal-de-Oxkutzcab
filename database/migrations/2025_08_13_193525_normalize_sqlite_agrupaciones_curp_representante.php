<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        // Asegura que la tabla final se llame "agrupaciones"
        if (Schema::hasTable('proveedores') && !Schema::hasTable('agrupaciones')) {
            Schema::rename('proveedores', 'agrupaciones');
        }

        if ($driver === 'sqlite') {
            // --------- REBUILD EN SQLITE (sin drops conflictivos) ---------
            DB::statement('PRAGMA foreign_keys=off');

            // Crea la nueva tabla con el esquema deseado (SOLO curp_representante)
            DB::statement("
                CREATE TABLE IF NOT EXISTS agrupaciones_new (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    nombre_agrupacion TEXT,
                    nombre_representante TEXT,
                    email_representante TEXT,
                    curp_representante TEXT,
                    rfc_agrupacion TEXT,
                    direccion_agrupacion TEXT,
                    superficie_cosecha NUMERIC,
                    tipo_suelo TEXT,
                    num_trabajadores INTEGER,
                    horas_trabajo INTEGER,
                    fecha_inicio TEXT,
                    fecha_cosecha TEXT,
                    tipo_maquinaria TEXT,
                    estado TEXT DEFAULT 'pendiente',
                    created_at TEXT NULL,
                    updated_at TEXT NULL
                )
            ");

            // Copia datos mapeando posibles columnas antiguas
            DB::statement("
                INSERT INTO agrupaciones_new (
                    id, nombre_agrupacion, nombre_representante, email_representante, curp_representante,
                    rfc_agrupacion, direccion_agrupacion, superficie_cosecha, tipo_suelo, num_trabajadores,
                    horas_trabajo, fecha_inicio, fecha_cosecha, tipo_maquinaria, estado, created_at, updated_at
                )
                SELECT
                    id,
                    COALESCE(nombre_agrupacion, nombre),
                    nombre_representante,
                    COALESCE(email_representante, email),
                    COALESCE(curp_representante, curp),
                    COALESCE(rfc_agrupacion, rfc),
                    direccion_agrupacion,
                    superficie_cosecha,
                    tipo_suelo,
                    num_trabajadores,
                    horas_trabajo,
                    fecha_inicio,
                    fecha_cosecha,
                    tipo_maquinaria,
                    COALESCE(estado, 'pendiente'),
                    created_at,
                    updated_at
                FROM agrupaciones
            ");

            // Reemplaza tabla
            DB::statement("DROP TABLE agrupaciones");
            DB::statement("ALTER TABLE agrupaciones_new RENAME TO agrupaciones");

            // Índices únicos (solo si no existen)
            DB::statement("CREATE UNIQUE INDEX IF NOT EXISTS agrupaciones_curp_representante_unique ON agrupaciones(curp_representante)");
            DB::statement("CREATE UNIQUE INDEX IF NOT EXISTS agrupaciones_email_representante_unique ON agrupaciones(email_representante)");

            DB::statement('PRAGMA foreign_keys=on');
        } else {
            // --------- MYSQL / POSTGRES: cambios directos ---------

            // 1) Crear curp_representante si no existe
            if (!Schema::hasColumn('agrupaciones', 'curp_representante')) {
                Schema::table('agrupaciones', function (Blueprint $table) {
                    $table->string('curp_representante', 18)->nullable()->after('email_representante');
                });
            }

            // 2) Backfill desde curp si existía
            if (Schema::hasColumn('agrupaciones', 'curp')) {
                DB::table('agrupaciones')
                    ->whereNull('curp_representante')
                    ->whereNotNull('curp')
                    ->update(['curp_representante' => DB::raw('curp')]);
            }

            // 3) Borrar columna curp si aún existe
            if (Schema::hasColumn('agrupaciones', 'curp')) {
                Schema::table('agrupaciones', function (Blueprint $table) {
                    $table->dropColumn('curp');
                });
            }

            // 4) Crear índices únicos SOLO si no existen
            if (!$this->indexExists('agrupaciones', 'agrupaciones_curp_representante_unique')) {
                Schema::table('agrupaciones', function (Blueprint $table) {
                    if (Schema::hasColumn('agrupaciones', 'curp_representante')) {
                        $table->unique('curp_representante', 'agrupaciones_curp_representante_unique');
                    }
                });
            }

            if (!$this->indexExists('agrupaciones', 'agrupaciones_email_representante_unique')) {
                Schema::table('agrupaciones', function (Blueprint $table) {
                    if (Schema::hasColumn('agrupaciones', 'email_representante')) {
                        $table->unique('email_representante', 'agrupaciones_email_representante_unique');
                    }
                });
            }

            // 5) (Opcional) volver NOT NULL curp_representante si ya no hay nulos
            try {
                DB::table('agrupaciones')
                    ->whereNull('curp_representante')
                    ->update(['curp_representante' => '']);
                Schema::table('agrupaciones', function (Blueprint $table) {
                    $table->string('curp_representante', 18)->nullable(false)->change();
                });
            } catch (\Throwable $e) {
                // Ignora si el motor no soporta change() o si hay datos inconsistentes
            }
        }
    }

    public function down(): void
    {
        // No destructivo por seguridad. Si necesitas revertir,
        // crea otra migración específica.
    }

    /**
     * Verifica si un índice existe en la tabla, según el driver actual.
     */
    private function indexExists(string $table, string $index): bool
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            $row = DB::selectOne("
                SELECT COUNT(1) AS c
                FROM information_schema.statistics
                WHERE table_schema = DATABASE()
                  AND table_name = ?
                  AND index_name = ?
            ", [$table, $index]);
            return (int)($row->c ?? 0) > 0;
        }

        if ($driver === 'pgsql') {
            $row = DB::selectOne("
                SELECT 1
                FROM pg_indexes
                WHERE tablename = ?
                  AND indexname = ?
                LIMIT 1
            ", [$table, $index]);
            return (bool) $row;
        }

        if ($driver === 'sqlite') {
            $rows = DB::select("PRAGMA index_list('$table')");
            foreach ($rows as $r) {
                $name = $r->name ?? ($r->Name ?? null);
                if ($name === $index) return true;
            }
            return false;
        }

        return false;
    }
};
