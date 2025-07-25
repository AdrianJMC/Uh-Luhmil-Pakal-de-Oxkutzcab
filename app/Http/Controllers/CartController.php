<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto; // Asegúrate de importar el modelo

class CartController extends Controller
{

    //Funciona para ir al carrito
    public function index()
    {
        $cart = $this->getCartData();
        return view('carrito', compact('cart'));
    }

    //Funciona para agregar productos al carrito
    public function add(Request $request)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
            }
            return redirect()->route('seleccion.login')
                ->with('error', 'Debes iniciar sesión para agregar productos al carrito');
        }

        if (Auth::guard('agrupacion')->check()) {
            return response()->json(['success' => false, 'message' => 'Las agrupaciones no pueden usar el carrito'], 403);
        }

        $productId = $request->input('product_id');
        $product = Producto::findOrFail($productId);

        if ($product->estado != 'aprobado') {
            return redirect()->back()->with('error', 'Este producto no está disponible actualmente');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 0.5;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->nombre,
                'price' => $product->precio,
                'image' => $product->imagen,
                'quantity' => 0.5,
                'agrupacion' => $product->agrupacion->nombre_agrupacion ?? 'Agrupación desconocida'
            ];
        }

        session()->put('cart', $cart);

        // Aquí la llamada para guardar en BD
        $this->persistCartToDB();

        session()->flash('added_product', $productId);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => $this->getCartCount(),
                'product_id' => $productId
            ]);
        }

        return redirect()->back()
            ->with('success', 'Producto agregado al carrito')
            ->with('cart_count', $this->getCartCount());
    }


    // Funciona para eliminar productos del carrito
    public function remove($key)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$key])) {
            return redirect()->route('carrito')->with('error', 'Producto no encontrado en el carrito');
        }

        unset($cart[$key]);
        session()->put('cart', $cart);

        $this->persistCartToDB(); // ✅ Aquí antes del return

        return redirect()->route('carrito')->with('success', 'Producto eliminado del carrito');
    }


    // Funciona para actualizar la cantidad de productos en el carrito 
    public function update(Request $request, $productId)
    {
        $action = $request->input('action');
        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
            return redirect()->route('carrito')
                ->with('error', 'Producto no encontrado en el carrito');
        }

        // Validar producto en BD
        $product = Producto::find($productId);
        if (!$product || $product->estado != 'aprobado') {
            $cart[$productId]['quantity'] = 0.5; // Mantener el producto en 0.5 si ya no está disponible
            session()->put('cart', $cart);
            $this->persistCartToDB(); // ✅ también aquí, en esta ruta de salida

            if ($request->ajax()) {
                return response()->json(['error' => 'Producto no disponible'], 400);
            }

            return redirect()->route('carrito')
                ->with('error', 'Este producto ya no está disponible');
        }

        // Acciones
        if ($action === 'increase') {
            $cart[$productId]['quantity'] += 0.5;
        } elseif ($action === 'decrease') {
            $newQuantity = $cart[$productId]['quantity'] - 0.5;
            $cart[$productId]['quantity'] = max($newQuantity, 0.5); // Nunca baja de 0.5
        }

        // Actualizar precio por si cambió
        $cart[$productId]['price'] = $product->precio;

        session()->put('cart', $cart);
        $this->persistCartToDB(); // ✅ Aquí antes del return o response

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'quantity' => $this->formatQuantity($cart[$productId]['quantity']),
                'itemTotal' => number_format($cart[$productId]['price'] * $cart[$productId]['quantity'], 2),
                'subtotal' => number_format($this->calculateSubtotal($cart), 2),
                'tax' => number_format($this->calculateSubtotal($cart) * 0.16, 2),
                'total' => number_format($this->calculateTotal($cart), 2),
                'totalQuantity' => array_sum(array_column($cart, 'quantity')),
                'productCount' => count($cart)
            ]);
        }

        return redirect()->route('carrito')
            ->with('success', 'Cantidad actualizada');
    }


    protected function persistCartToDB()
    {
        if (Auth::check() && Auth::user()) {
            \App\Models\Carrito::updateOrCreate(
                ['user_id' => Auth::id()],
                ['items' => session()->get('cart', [])]
            );
        }
    }

    //Funciona para formatear la cantidad de productos
    protected function formatQuantity($qty)
    {
        return fmod($qty, 1) === 0.0 ? (int)$qty : number_format($qty, 1);
    }

    //Funciona para calcular el subtotal del carrito
    protected function calculateSubtotal($cart)
    {
        return array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    //Funciona para calcular el total del carrito
    protected function calculateTotal($cart)
    {
        $subtotal = $this->calculateSubtotal($cart);
        $shipping = 350.0;
        $tax = $subtotal * 0.16;
        return $subtotal + $shipping + $tax;
    }

    //Funciona para contar el número de productos en el carrito
    protected function getCartCount()
    {
        $cart = session()->get('cart', []);
        $productCount = count($cart); // ← Aquí cuentas productos únicos

        return $productCount > 5 ? '5+' : $productCount;
    }

    //Funciona para obtener los datos del carrito
    protected function getCartData()
    {
        $cart = session()->get('cart', []);
        $cartData = [];

        foreach ($cart as $key => $item) {
            $product = Producto::find($item['id']);
            if ($product && $product->estado == 'aprobado') {
                $cartData[$key] = [ // <- conserva el índice
                    'id' => $product->id,
                    'name' => $product->nombre,
                    'price' => $product->precio,
                    'image' => $product->imagen,
                    'quantity' => $item['quantity'],
                    'agrupacion' => $product->agrupacion->nombre_agrupacion ?? 'Agrupación desconocida'
                ];
            }
        }

        session()->put('cart', $cartData);
        return $cartData;
    }
}
