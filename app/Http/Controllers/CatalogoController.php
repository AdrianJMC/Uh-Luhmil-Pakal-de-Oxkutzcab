<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Jenssegers\Agent\Agent;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $agent = new \Jenssegers\Agent\Agent();
        $perPage = $agent->isMobile() ? 14 : 30;

        $query = Producto::where('estado', 'aprobado');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'like', '%' . $search . '%');
        }

        $products = $query->paginate($perPage);

        return view('catalogo', compact('products'));
    }
}
