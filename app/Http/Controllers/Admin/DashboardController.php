<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Agrupacion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PedidoProducto;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPedidos            = \App\Models\Pedido::count();
        $totalUsuarios           = \App\Models\User::count();
        $agrupacionesAprobadas   = \App\Models\Agrupacion::where('estado', 'aprobado')->count();
        $totalProductosAprobados = \App\Models\Producto::where('estado', 'aprobado')->count();

        // ---- Expresiones por motor ----
        $driver = DB::getDriverName(); // 'sqlite' | 'mysql' | 'pgsql' | 'mariadb'

        if ($driver === 'sqlite') {
            $yearExpr  = "CAST(strftime('%Y', created_at) AS INT)";
            $monthExpr = "CAST(strftime('%m', created_at) AS INT)";
            $dayExpr   = "date(created_at)";
        } elseif ($driver === 'pgsql') {
            $yearExpr  = "EXTRACT(YEAR FROM created_at)";
            $monthExpr = "EXTRACT(MONTH FROM created_at)";
            $dayExpr   = "CAST(created_at AS date)";
        } else { // mysql / mariadb
            $yearExpr  = "YEAR(created_at)";
            $monthExpr = "MONTH(created_at)";
            $dayExpr   = "DATE(created_at)";
        }

        // ---- Ventas por mes (anio, mes) ----
        $ventasPorMes = \App\Models\Pedido::selectRaw("
            $yearExpr  AS anio,
            $monthExpr AS mes,
            SUM(total) AS total_ventas
        ")
            ->groupByRaw("$yearExpr, $monthExpr")
            ->orderByRaw("$yearExpr ASC, $monthExpr ASC")
            ->get();

        // ---- Ventas por categoría ----
        $ventasPorCategoria = DB::table('pedido_productos')
            ->join('productos', 'pedido_productos.producto_id', '=', 'productos.id')
            ->select('productos.categoria', DB::raw('COUNT(*) as total'))
            ->groupBy('productos.categoria')
            ->get();

        // ---- Top 3 agrupaciones por cantidad ----
        $ventasPorAgrupacion = \App\Models\PedidoProducto::selectRaw('agrupaciones.nombre_agrupacion as nombre, SUM(pedido_productos.cantidad) as total')
            ->join('productos', 'pedido_productos.producto_id', '=', 'productos.id')
            ->join('agrupaciones', 'productos.agrupacion_id', '=', 'agrupaciones.id')
            ->groupBy('agrupaciones.nombre_agrupacion')
            ->orderByDesc('total')
            ->take(3)
            ->get();

        // ---- Ventas por día (últimos 7) ----
        $hace7 = Carbon::now()->subDays(7);
        $ventasPorDia = \App\Models\Pedido::selectRaw("$dayExpr AS fecha, SUM(total) AS total")
            ->where('created_at', '>=', $hace7)
            ->groupByRaw("$dayExpr")
            ->orderByRaw("$dayExpr ASC")
            ->get();

        return view('admin.dashboard', compact(
            'totalPedidos',
            'totalUsuarios',
            'agrupacionesAprobadas',
            'totalProductosAprobados',
            'ventasPorMes',
            'ventasPorCategoria',
            'ventasPorAgrupacion',
            'ventasPorDia'
        ));
    }
}
