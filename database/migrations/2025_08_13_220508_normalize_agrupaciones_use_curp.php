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
            // ---------- REBUILD EN SQLITE (patrón seguro) ----------
            DB::statement('PRAGMA foreign_keys=off');

            // Esquema final: SOLO "curp" (no curp_representante)
            DB::statement("
                CREATE TABLE IF NOT EXISTS agrupaciones_new (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    nombre_agrupacion TEXT,
                    nombre_representante TEXT,
                    email_representante TEXT,
                    curp TEXT,                        -- <- columna final
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

            // Copia datos mapeando posibles columnas antiguas (curp / curp_representante)
            DB::statement("
                INSERT INTO agrupaciones_new (
                    id, nombre_agrupacion, nombre_representante, email_representante, curp,
                    rfc_agrupacion, direccion_agrupacion, superficie_cosecha, tipo_suelo,
                    num_trabajadores, horas_trabajo, fecha_inicio, fecha_cosecha,
                    tipo_maquinaria, estado, created_at, updated_at
                )
                SELECT
                    id,
                    COALESCE(nombre_agrupacion, nombre),
                    nombre_representante,
                    COALESCE(email_representante, email),
                    COALESCE(curp, curp_representante),             -- <- aquí unificamos a curp
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

            // Índices únicos coherentes (crea si no existen)
            DB::statement("CREATE UNIQUE INDEX IF NOT EXISTS agrupaciones_curp_unique ON agrupaciones(curp)");
            DB::statement("CREATE UNIQUE INDEX IF NOT EXISTS agrupaciones_email_representante_unique ON agrupaciones(email_representante)");

            DB::statement('PRAGMA foreign_keys=on');
        } else {
            // ---------- MYSQL / POSTGRES ----------
            // 1) Crea "curp" si no existe
            if (!Schema::hasColumn('agrupaciones', 'curp')) {
                Schema::table('agrupaciones', function (Blueprint $table) {
                    $table->string('curp', 18)->nullable()->after('email_representante');
                });
            }

            // 2) Backfill desde curp_representante si existe y curp está null
            if (Schema::hasColumn('agrupaciones', 'curp_representante')) {
                DB::table('agrupaciones')
                    ->whereNull('curp')
                    ->whereNotNull('curp_representante')
                    ->update(['curp' => DB::raw('curp_representante')]);
            }

            // 3) Elimina índices viejos y crea el nuevo sólo si no existe
            $this->dropIndexIfExists('agrupaciones', 'agrupaciones_curp_representante_unique');
            $this->dropIndexIfExists('agrupaciones', 'proveedores_curp_unique');
            $this->dropIndexIfExists('agrupaciones', 'agrupaciones_email_unique');
            $this->dropIndexIfExists('agrupaciones', 'proveedores_email_unique');

            if (!$this->indexExists('agrupaciones', 'agrupaciones_curp_unique')) {
                Schema::table('agrupaciones', function (Blueprint $table) {
                    $table->unique('curp', 'agrupaciones_curp_unique');
                });
            }
            if (!$this->indexExists('agrupaciones', 'agrupaciones_email_representante_unique')) {
                Schema::table('agrupaciones', function (Blueprint $table) {
                    if (Schema::hasColumn('agrupaciones', 'email_representante')) {
                        $table->unique('email_representante', 'agrupaciones_email_representante_unique');
                    }
                });
            }

            // 4) Opcional: NOT NULL (cuando ya estés seguro de que no hay nulos)
            try {
                DB::table('agrupaciones')->whereNull('curp')->update(['curp' => '']);
                Schema::table('agrupaciones', function (Blueprint $table) {
                    $table->string('curp', 18)->nullable(false)->change();
                });
            } catch (\Throwable $e) {
                // Ignora si tu motor no soporta change() o hay datos inconsistentes
            }

            // 5) Quita curp_representante si existe (ya no lo usaremos)
            if (Schema::hasColumn('agrupaciones', 'curp_representante')) {
                Schema::table('agrupaciones', function (Blueprint $table) {
                    $table->dropColumn('curp_representante');
                });
            }
        }
    }

    public function down(): void
    {
        // Sin reversión destructiva por seguridad
    }

    // ---------- Helpers para índices ----------
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

    private function dropIndexIfExists(string $table, string $index): void
    {
        try {
            Schema::table($table, function (Blueprint $tbl) use ($index) {
                $tbl->dropUnique($index);
            });
        } catch (\Throwable $e) {
            // Si no existe, ignoramos
        }
        // Para SQLite, si el nombre no coincide, se ignora igual.
    }
};
