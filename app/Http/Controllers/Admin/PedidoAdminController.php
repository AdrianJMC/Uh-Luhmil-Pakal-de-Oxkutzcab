<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido; // Asegúrate de importar el modelo Pedido    
use Illuminate\Pagination\LengthAwarePaginator;

class PedidoAdminController extends Controller
{
    public function index()
    {
        // Cargamos las relaciones para que cada pedido tenga sus productos con agrupaciones
        $pedidos = Pedido::with('productos.producto.agrupacion')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.Pedidos.index', compact('pedidos'));
    }


    public function verProductos($id)
    {
        $pedido = Pedido::with('productos.producto.agrupacion')->findOrFail($id);

        // Obtener la colección completa
        $productos = $pedido->productos;

        // Paginar manualmente
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 12;
        $currentItems = $productos->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginados = new LengthAwarePaginator($currentItems, $productos->count(), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);
        $pedidos = Pedido::with('productos.producto.agrupacion')->paginate(10);

        return view('admin.Pedidos.show-producto', compact('pedido', 'paginados'));
    }
}
