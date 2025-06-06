<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Http\Requests\StoreProveedorRequest;

class ProveedorController extends Controller
{
    public function create()
    {
        return view('proveedores.registro');
    }

    public function store(StoreProveedorRequest $request)
    {
        Proveedor::create($request->validated());

        return redirect()
            ->route('proveedores.create')
            ->with('success', '¡Registro exitoso!');
    }
}
