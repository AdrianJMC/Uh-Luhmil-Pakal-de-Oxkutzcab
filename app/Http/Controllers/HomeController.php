<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Slide;
use App\Models\Info;    // ① Importa Info

class HomeController extends Controller
{
    public function index()
    {
        // Sección "home"
        $home   = Page::where('slug','home')->firstOrFail();

        // Slides para el slider
        $slides = Slide::orderBy('orden')->get();

        // 3) Trae todas las infos
        $infos  = Info::orderBy('orden')->get();

        // Pásalas al blade
        return view('home', compact('home','slides','infos'));
    }
}
