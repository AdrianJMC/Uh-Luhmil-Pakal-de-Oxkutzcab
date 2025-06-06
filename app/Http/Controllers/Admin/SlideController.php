<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    // 1) Index: muestra todos los slides
    public function index()
    {
        $slides = Slide::orderBy('orden')->get();
        return view('admin.slides.index', compact('slides'));
    }

    // 2) Create: formulario para crear un nuevo slide
    public function create()
    {
        return view('admin.slides.create');
    }

    // 3) Store: guarda el slide en BD
    public function store(Request $request)
    {
        // Verifica si ya hay 6 slides
        if (Slide::count() >= 6) {
            return redirect()->back()
                ->with('error', 'Ya has alcanzado el límite máximo de 6 slides.');
        }

        $data = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'orden'       => 'required|integer',
            'imagen'      => 'required|image',
        ]);

        $data['imagen_ruta'] = $request->file('imagen')->store('slides', 'public');

        Slide::create($data);

        return redirect()->route('admin.slides.index')->with('success', 'Slide creado correctamente.');
    }

    // 4) Edit: formulario para editar un slide existente
    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', compact('slide'));
    }

    // 5) Update: actualiza datos del slide
    public function update(Request $request, Slide $slide)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'orden'       => 'required|integer',
            'imagen'      => 'nullable|image',
        ]);

        if ($request->hasFile('imagen')) {
            Storage::disk('public')->delete($slide->imagen_ruta);
            $data['imagen_ruta'] = $request->file('imagen')->store('slides', 'public');
        }

        $slide->update($data);

        return redirect()
            ->route('admin.slides.index')
            ->with('success', 'Slide actualizado correctamente.');
    }

    // 6) Destroy: elimina un slide
    public function destroy(Slide $slide)
    {
        Storage::disk('public')->delete($slide->imagen_ruta);
        $slide->delete();

        return back()->with('success', 'Slide eliminado correctamente.');
    }
}
