<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Catalogo;
use App\Models\Agrupacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CatalogoController extends Controller
{
    public function agrupacionesPorCatalogo(Request $request, $catalogoId)
    {
        try {
            $catalogo = Catalogo::findOrFail($catalogoId);

            // Paginamos directamente agrupaciones que tengan productos del catálogo
            $agrupaciones = Agrupacion::whereHas('productos', function ($query) use ($catalogo) {
                $query->where('categoria', $catalogo->nombre);
            })
                ->select('id', 'nombre_agrupacion', 'nombre_representante', 'email_representante')
                ->distinct()
                ->paginate(10)
                ->withPath("/catalogos/{$catalogoId}/agrupaciones");

            return response()->json($agrupaciones);
        } catch (\Exception $e) {
            Log::error('Error en agrupacionesPorCatalogo: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al cargar agrupaciones',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
