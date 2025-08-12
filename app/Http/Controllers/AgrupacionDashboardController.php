<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pedido;

class AgrupacionDashboardController extends Controller
{
    public function index()
    {
        $agrupacionId = Auth::guard('agrupacion')->id();

        $totalPedidos = DB::table('pedido_productos')
            ->where('agrupacion_id', $agrupacionId)
            ->distinct('pedido_id')
            ->count('pedido_id');

        $totalProductos = Producto::where('agrupacion_id', $agrupacionId)->count();

        $productosAprobados = Producto::where('agrupacion_id', $agrupacionId)
            ->where('estado', 'aprobado')
            ->count();

        $montoTotalVendido = DB::table('pedido_productos')
            ->where('agrupacion_id', $agrupacionId)
            ->sum('total');

        $ultimosPedidos = DB::table('pedido_productos')
            ->join('pedidos', 'pedido_productos.pedido_id', '=', 'pedidos.id')
            ->join('users', 'pedidos.user_id', '=', 'users.id')
            ->select(
                'pedido_productos.pedido_id as pedido_id',
                'pedidos.folio',
                'pedidos.nombre_cliente',
                'pedidos.telefono',
                DB::raw('SUM(pedido_productos.total) as total'),
                'pedidos.created_at'
            )
            ->where('pedido_productos.agrupacion_id', $agrupacionId)
            ->groupBy('pedido_productos.pedido_id', 'pedidos.folio', 'pedidos.nombre_cliente', 'pedidos.telefono', 'pedidos.created_at')
            ->orderByDesc('pedidos.created_at')
            ->limit(5)
            ->get();

        // === Ventas por día (últimos N días: 7 o 30) ===
        $rangoDias = request('rango', 7); // Por defecto 7 días

        $ventasPorSemana = Pedido::selectRaw('DATE(created_at) as fecha, SUM(total) as total')
            ->whereHas('productos', function ($query) use ($agrupacionId) {
                $query->where('agrupacion_id', $agrupacionId);
            })
            ->where('created_at', '>=', now()->subDays($rangoDias - 1)->startOfDay())
            ->groupByRaw('DATE(created_at)')
            ->orderBy('fecha')
            ->get()
            ->mapWithKeys(function ($venta) {
                return [Carbon::parse($venta->fecha)->format('d/m') => round($venta->total, 2)];
            });

        // Crear labels y valores, incluyendo días sin ventas
        $labels = collect();
        $valores = collect();

        for ($i = $rangoDias - 1; $i >= 0; $i--) {
            $fecha = now()->subDays($i)->format('d/m');
            $labels->push($fecha);
            $valores->push($ventasPorSemana[$fecha] ?? 0);
        }

        $labelsSemana = $labels;
        $valoresSemana = $valores;

        return view('agrupaciones.Dashboard-agrupaciones', compact(
            'totalPedidos',
            'totalProductos',
            'productosAprobados',
            'montoTotalVendido',
            'ultimosPedidos',
            'labelsSemana',
            'valoresSemana',
            'rangoDias'
        ));
    }
}
