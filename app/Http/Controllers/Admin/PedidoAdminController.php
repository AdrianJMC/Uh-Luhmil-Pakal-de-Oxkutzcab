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
        $pedidos = Pedido::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.pedidos.index', compact('pedidos'));
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

        return view('admin.pedidos.show-producto', compact('pedido', 'paginados'));
    }
}
