<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function quienesSomos()
    {
        return view('quienes-somos');
    }
}
