<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Agrupacion;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buscar = request('buscar'); // texto de búsqueda

        // Pendientes
        $queryPendientes = Producto::with('agrupacion')
            ->where('estado', 'pendiente_aprobacion');

        // Aprobados
        $queryAprobados = Producto::with('agrupacion')
            ->where('estado', 'aprobado');

        if ($buscar) {
            $queryPendientes->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('categoria', 'like', "%{$buscar}%")
                    ->orWhereHas('agrupacion', function ($q2) use ($buscar) {
                        $q2->where('nombre_agrupacion', 'like', "%{$buscar}%");
                    });
            });

            $queryAprobados->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('categoria', 'like', "%{$buscar}%")
                    ->orWhereHas('agrupacion', function ($q2) use ($buscar) {
                        $q2->where('nombre_agrupacion', 'like', "%{$buscar}%");
                    });
            });
        }

        $productosPendientes = $queryPendientes
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(['buscar' => $buscar, 'tab' => 'pendientes']);

        $productosAprobados = $queryAprobados
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(['buscar' => $buscar, 'tab' => 'aprobados']);

        return view('admin.Productos.index', compact('productosPendientes', 'productosAprobados'));
    }


    //Aprobar producto
    public function aprobar($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->estado = 'aprobado';
        $producto->save();

        return redirect()->route('admin.productos.index', ['tab' => 'pendientes'])
            ->with('success', 'Producto aprobado correctamente.');
    }

    //Rechazar producto
    public function rechazar(Request $request, $id)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:255',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->estado = 'rechazado';
        $producto->motivo_rechazo = $request->motivo_rechazo;
        $producto->save();

        return redirect()->route('admin.productos.index', ['tab' => 'pendientes'])
            ->with('success', 'Producto rechazado correctamente.');
    }

    //Aprobar multiples productos
    public function aprobarMultiples(Request $request)
    {
        $ids = $request->input('productos');

        if (!is_array($ids) || empty($ids)) {
            return redirect()->back()->withErrors(['No se seleccionaron productos.']);
        }

        Producto::whereIn('id', $ids)->update(['estado' => 'aprobado']);

        return redirect()->route('admin.productos.index', ['tab' => 'pendientes'])
            ->with('success', 'Productos aprobados correctamente.');
    }

    //Rechazar multiples productos
    public function rechazarMultiples(Request $request)
    {
        $idsRaw = $request->input('productos_ids');
        $motivo = $request->input('motivo_rechazo');

        $ids = explode(',', $idsRaw);

        $request->validate([
            'motivo_rechazo' => 'required|string|max:255',
        ]);

        Producto::whereIn('id', $ids)->update([
            'estado' => 'rechazado',
            'motivo_rechazo' => $motivo,
        ]);

        return redirect()->route('admin.productos.index', ['tab' => 'pendientes'])
            ->with('success', 'Productos rechazados correctamente.');
    }

    //Ver detalles de un producto
    public function detalles($id)
    {
        $producto = Producto::with('agrupacion')->findOrFail($id);
        return view('admin.Productos.detalles_productos', compact('producto'));
    }

    //editar un producto
    public function edit($id)
    {
        $producto     = Producto::findOrFail($id);
        $agrupaciones = Agrupacion::orderBy('nombre_agrupacion')->get();

        // Tus listas de categorías y unidades
        $categorias = [
            'Hortalizas',
            'Frutas',
            'Cítricos',
            'Legumbres',
            'Tubérculos',
            'Hierbas aromáticas',
            'Verduras de hoja',
            'Chiles y pimientos',
            'Melones y sandías',
            'Raíces comestibles',
            'Flores comestibles',
            'Granos básicos',
            'Productos procesados',
            'Semillas',
            'Plantas medicinales',
            'Otros'
        ];

        $unidades = [
            'kg',
            'gramos',
            'tonelada',
            'litro',
            'mililitro',
            'pieza',
            'docena',
            'manojo',
            'caja',
            'bulto',
            'saco',
            'paquete',
            'botella',
            'canastilla',
            'bandeja',
            'otros'
        ];

        // Recupera la pestaña actual para que, al cancelar o guardar, regreses donde viniste
        $tab = request('tab', 'aprobados');

        return view('admin.Productos.edit-productos', compact(
            'producto',
            'agrupaciones',
            'categorias',
            'unidades',
            'tab'
        ));
    }

    //Actualizar un producto
    public function update(Request $request, $id)
    {
        $request->validate([
            'agrupacion_id' => 'nullable|exists:agrupaciones,id',
            'nombre'        => 'required|string|max:255',
            'categoria'     => 'required|string|max:255',
            'precio'        => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'unidad'        => 'required|string|max:50',
            'descripcion'   => 'nullable|string',
            'estado'        => 'required|in:pendiente_aprobacion,aprobado,rechazado',
            'imagen'        => 'nullable|image|max:2048',
        ]);

        $producto = Producto::findOrFail($id);

        // procesar imagen
        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete(parse_url($producto->imagen, PHP_URL_PATH));
            }
            $path = $request->file('imagen')->store('productos', 'public');
            $producto->imagen = Storage::url($path);
        }

        // asignar campos
        $producto->agrupacion_id = $request->input('agrupacion_id');
        $producto->nombre        = $request->input('nombre');
        $producto->categoria     = $request->input('categoria');
        $producto->precio        = $request->input('precio');
        $producto->stock         = $request->input('stock');
        $producto->unidad        = $request->input('unidad');
        $producto->descripcion   = $request->input('descripcion');
        $producto->estado        = $request->input('estado');
        $producto->save();

        // redirigir de vuelta a la pestaña correcta
        $tab = $request->input('tab', 'aprobados');

        return redirect()
            ->route('admin.productos.index', ['tab' => $tab])
            ->with('success', 'Producto actualizado correctamente.');
    }


    //eliminar un producto
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        // Opcional: borrar imagen del disco
        if ($producto->imagen) {
            Storage::disk('public')->delete(parse_url($producto->imagen, PHP_URL_PATH));
        }

        $producto->delete();

        return redirect()
            ->route('admin.productos.index', ['tab' => request('tab', 'pendientes')])
            ->with('success', 'Producto eliminado correctamente.');
    }
}
