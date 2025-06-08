<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Slide;
use App\Models\Info;
use Illuminate\Support\Facades\Log; // ← asegurate de importar esto

class HomeController extends Controller
{
    public function index()
    {
        // Log para verificar si entra al controlador
        Log::info('✅ Entró correctamente al HomeController@index');

        // También crea un archivo temporal por si no se escribe en laravel.log
        file_put_contents(storage_path('logs/debug.txt'), "✅ Llega a HomeController@index\n", FILE_APPEND);

        // Sección "home"
        $home   = Page::where('slug','home')->firstOrFail();

        // Slides para el slider
        $slides = Slide::orderBy('orden')->get();

        // Trae todas las infos
        $infos  = Info::orderBy('orden')->get();

        return view('home', compact('home','slides','infos'));
    }
}
