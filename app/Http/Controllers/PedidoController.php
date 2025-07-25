<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PedidoController extends Controller
{
    public function realizar(Request $request)
    {
        try {
            $request->validate([
                'telefono' => 'required|string|max:20',
            ]);

            $user = Auth::user();
            $cart = session()->get('cart', []);

            if (empty($cart)) {
                return redirect()->route('carrito')->with('error', 'El carrito está vacío');
            }

            // Obtener el último número de secuencia para la fecha actual
            $today = date('Ymd');
            $lastPedido = Pedido::where('folio', 'like', $today . '-%')
                ->orderBy('folio', 'desc')
                ->first();

            // Determinar el siguiente número de secuencia
            $sequenceNumber = 1;
            if ($lastPedido) {
                $lastSequence = explode('-', $lastPedido->folio);
                $sequenceNumber = (int)end($lastSequence) + 1;
            }

            $folio = $today . '-' . $sequenceNumber;

            DB::beginTransaction();

            // Crea el pedido
            $pedido = Pedido::create([
                'user_id' => $user->id,
                'nombre_cliente' => $user->name,
                'telefono' => $request->telefono,
                'folio' => $folio,
                'total' => array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0),
            ]);

            foreach ($cart as $item) {
                $producto = Producto::find($item['id']);
                if (!$producto) continue;

                PedidoProducto::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $producto->id,
                    'agrupacion_id' => $producto->agrupacion_id,
                    'cantidad' => $item['quantity'],
                    'precio_unitario' => $producto->precio,
                    'total' => $producto->precio * $item['quantity'],
                ]);
            }

            DB::commit();

            session()->forget('cart');

            return view('partials.carrito.agradecimiento-pedido', ['folio' => $folio]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al realizar pedido: ' . $e->getMessage());
            return redirect()->route('carrito')->with('error', 'Ocurrió un error al procesar tu pedido');
        }
    }
}
