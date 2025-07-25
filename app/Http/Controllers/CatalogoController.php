<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Jenssegers\Agent\Agent;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $agent = new Agent();

        $perPage = $agent->isMobile() ? 14 : 30;

        $products = Producto::where('estado', 'aprobado')->paginate($perPage);

        return view('catalogo', compact('products'));
    }
}
