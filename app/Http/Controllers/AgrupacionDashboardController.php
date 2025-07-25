<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgrupacionDashboardController extends Controller
{
    public function index()
    {
        return view('agrupaciones.Dashboard-agrupaciones');
    }
}
