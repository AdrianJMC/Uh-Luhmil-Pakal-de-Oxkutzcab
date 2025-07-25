<?php

namespace App\Http\Controllers\Agrupacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PedidoProducto;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $agrupacionId = Auth::guard('agrupacion')->id();

        // Detectar si es móvil para mostrar 12 por página, si no, 16
        $isMobile = $request->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', $request->header('User-Agent'));
        $porPagina = $isMobile ? 12 : 16;

        // Consulta eficiente con agregación y paginación
        $pedidos = DB::table('pedido_productos')
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
            ->paginate($porPagina);

        return view('agrupaciones.Apartados.Pedidos.Pedidos', compact('pedidos'));
    }

    public function verProductos(Request $request, $pedidoId)
    {
        $agrupacionId = Auth::guard('agrupacion')->id();

        // Detectar si es móvil o escritorio para definir cuántos productos mostrar por página
        $isMobile = $request->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', $request->header('User-Agent'));
        $porPagina = $isMobile ? 10 : 5;

        $productosPedido = PedidoProducto::with('producto', 'pedido')
            ->where('pedido_id', $pedidoId)
            ->where('agrupacion_id', $agrupacionId)
            ->paginate($porPagina);

        $pedido = $productosPedido->first()?->pedido;

        if (!$pedido) {
            abort(404);
        }

        return view('agrupaciones.Apartados.Pedidos.Acciones.ver-productos-clientes', [
            'pedido' => $pedido,
            'productosPedido' => $productosPedido,
        ]);
    }
}
