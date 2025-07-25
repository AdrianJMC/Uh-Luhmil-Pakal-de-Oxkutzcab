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
    /**
     * Muestra el dashboard de administración.
     */
    public function index()
    {
        $totalPedidos = Pedido::count();
        $totalUsuarios = User::count();
        $agrupacionesAprobadas = Agrupacion::where('estado', 'aprobado')->count();
        $totalProductosAprobados = \App\Models\Producto::where('estado', 'aprobado')->count();
        $ventasPorMes = Pedido::select(
            DB::raw("MONTH(created_at) as mes"),
            DB::raw("SUM(total) as total_ventas")
        )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->orderBy(DB::raw("MONTH(created_at)"))
            ->get();
        $ventasPorCategoria = DB::table('pedido_productos')
            ->join('productos', 'pedido_productos.producto_id', '=', 'productos.id')
            ->select('productos.categoria', DB::raw('COUNT(*) as total'))
            ->groupBy('productos.categoria')
            ->get();

        $ventasPorAgrupacion = PedidoProducto::selectRaw('agrupaciones.nombre_agrupacion as nombre, SUM(pedido_productos.cantidad) as total')
            ->join('productos', 'pedido_productos.producto_id', '=', 'productos.id')
            ->join('agrupaciones', 'productos.agrupacion_id', '=', 'agrupaciones.id')
            ->groupBy('agrupaciones.nombre_agrupacion')
            ->orderByDesc('total')
            ->take(3)
            ->get();



        $ventasPorDia = Pedido::selectRaw('DATE(created_at) as fecha, SUM(total) as total')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $topProductos = DB::table('pedido_productos')
            ->join('productos', 'pedido_productos.producto_id', '=', 'productos.id')
            ->select('productos.nombre', DB::raw('SUM(pedido_productos.cantidad) as total_vendidos'))
            ->groupBy('productos.nombre')
            ->orderByDesc('total_vendidos')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('totalPedidos', 'totalUsuarios', 'agrupacionesAprobadas', 'totalProductosAprobados', 'ventasPorMes', 'ventasPorCategoria', 'ventasPorAgrupacion', 'ventasPorDia', 'topProductos'));
    }
}
