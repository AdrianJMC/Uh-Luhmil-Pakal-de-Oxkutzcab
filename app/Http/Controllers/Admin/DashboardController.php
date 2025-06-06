<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard de administración.
     */
    public function index()
    {
        // Aquí, más adelante, podrías cargar datos:
        // $ordersCount = \App\Models\Order::count();
        // return view('admin.dashboard', compact('ordersCount'));

        return view('admin.dashboard');
    }
}
