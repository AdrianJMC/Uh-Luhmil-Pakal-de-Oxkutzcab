<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::orderBy('orden')->get();
        return view('admin.infos.index', compact('infos'));
    }

    public function create()
    {
        // Podemos pasar la cuenta actual de infos a la vista, 
        // para deshabilitar el botón “Crear” si ya hay 4.
        $infoCount = Info::count();
        return view('admin.infos.create', compact('infoCount'));
    }

    public function store(Request $request)
    {
        // 1) Verificamos si ya hay 4 (o más) registros en la tabla “infos”
        if (Info::count() >= 4) {
            // Redirigimos con un mensaje de error—puedes ajustarlo a tu gusto
            return redirect()
                ->route('admin.infos.index')
                ->with('error', 'No puedes crear más de 4 informaciónes.');
        }

        // 2) A partir de aquí va tu lógica normal de validación y guardado:

        $esVideo = $request->has('is_video');

        if ($esVideo) {
            // MODO “Video (YouTube/Vimeo)”
            $data = $request->validate([
                'video_id'     => 'required|string|max:255',
                'imagen_video' => 'nullable|image|max:5120',
                'orden'        => 'required|integer',
            ]);

            if ($request->hasFile('imagen_video')) {
                $data['imagen_ruta'] = $request
                    ->file('imagen_video')
                    ->store('infos', 'public');
            } else {
                $data['imagen_ruta'] = null;
            }

            $data['titulo']   = null;
            $data['texto']    = null;

        } else {
            // MODO “Contenido normal”
            $data = $request->validate([
                'titulo'        => 'required|string|max:255',
                'texto'         => 'required|string',
                'imagen_normal' => 'required|image|max:5120',
                'orden'         => 'required|integer',
            ]);

            $data['imagen_ruta'] = $request
                ->file('imagen_normal')
                ->store('infos', 'public');

            $data['video_id'] = null;
        }

        // 3) Creamos el registro
        Info::create([
            'titulo'      => $data['titulo'],
            'texto'       => $data['texto'],
            'video_id'    => $data['video_id'] ?? null,
            'imagen_ruta' => $data['imagen_ruta'],
            'orden'       => $data['orden'],
        ]);

        return redirect()
            ->route('admin.infos.index')
            ->with('success', 'Info creada correctamente.');
    }

    public function edit(Info $info)
    {
        return view('admin.infos.edit', compact('info'));
    }

    public function update(Request $request, Info $info)
    {
        $esVideo = $request->has('is_video');

        if ($esVideo) {
            $data = $request->validate([
                'video_id'     => 'required|string|max:255',
                'imagen_video' => 'nullable|image|max:5120',
                'orden'        => 'required|integer',
            ]);

            if ($request->hasFile('imagen_video')) {
                if ($info->imagen_ruta) {
                    Storage::disk('public')->delete($info->imagen_ruta);
                }
                $data['imagen_ruta'] = $request
                    ->file('imagen_video')
                    ->store('infos', 'public');
            } else {
                $data['imagen_ruta'] = $info->imagen_ruta;
            }

            $data['titulo'] = null;
            $data['texto']  = null;

        } else {
            $data = $request->validate([
                'titulo'        => 'required|string|max:255',
                'texto'         => 'required|string',
                'imagen_normal' => 'nullable|image|max:5120',
                'orden'         => 'required|integer',
            ]);

            if ($request->hasFile('imagen_normal')) {
                if ($info->imagen_ruta) {
                    Storage::disk('public')->delete($info->imagen_ruta);
                }
                $data['imagen_ruta'] = $request
                    ->file('imagen_normal')
                    ->store('infos', 'public');
            } else {
                $data['imagen_ruta'] = $info->imagen_ruta;
            }

            $data['video_id'] = null;
        }

        $info->update([
            'titulo'      => $data['titulo'],
            'texto'       => $data['texto'],
            'video_id'    => $data['video_id'],
            'imagen_ruta' => $data['imagen_ruta'],
            'orden'       => $data['orden'],
        ]);

        return back()->with('success', 'Info actualizada correctamente.');
    }

    public function destroy(Info $info)
    {
        if ($info->imagen_ruta) {
            Storage::disk('public')->delete($info->imagen_ruta);
        }
        $info->delete();

        return back()->with('success', 'Info eliminada correctamente.');
    }
}
