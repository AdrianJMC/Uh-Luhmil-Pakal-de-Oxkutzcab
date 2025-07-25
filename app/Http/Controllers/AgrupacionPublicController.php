<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agrupacion;


class AgrupacionPublicController extends Controller
{
    public function index(Request $request)
    {

        $isMobile = preg_match('/Mobile|Android|iPhone|iPad/i', $request->header('User-Agent'));
        $perPage = $isMobile ? 12 : 30;

        $agrupaciones = \App\Models\Agrupacion::where('estado', 'aprobado')
            ->paginate($perPage);

        return view('Agrupaciones', compact('agrupaciones'));
    }
}
