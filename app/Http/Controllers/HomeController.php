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
        try {
            $log = "";

            $log .= "✅ Entrando a HomeController@index\n";

            $home = \App\Models\Page::where('slug', 'home')->first();
            if (!$home) throw new \Exception("❌ No se encontró la página 'home'");

            $log .= "✅ Página home encontrada\n";

            $slides = \App\Models\Slide::orderBy('orden')->get();
            $log .= "✅ Slides encontrados: " . $slides->count() . "\n";

            $infos = \App\Models\Info::orderBy('orden')->get();
            $log .= "✅ Infos encontrados: " . $infos->count() . "\n";

            // Para ver logs temporalmente en la vista
            file_put_contents(storage_path('logs/debug.txt'), $log);

            return view('home', compact('home', 'slides', 'infos'));
        } catch (\Throwable $e) {
            // Si explota algo, log completo y lo mostramos
            $errorLog = "❌ ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString();
            file_put_contents(storage_path('logs/debug.txt'), $errorLog);

            return response("<pre>$errorLog</pre>", 500);
        }
    }
}
