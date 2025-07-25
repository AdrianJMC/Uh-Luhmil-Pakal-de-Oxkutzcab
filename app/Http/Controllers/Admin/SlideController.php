<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

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

        $data['imagen_ruta'] = $this->subirACloudinary($request->file('imagen'));

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
            $this->borrarDeCloudinary($slide->imagen_ruta);
            $data['imagen_ruta'] = $this->subirACloudinary($request->file('imagen'));
        }

        $slide->update($data);

        return redirect()
            ->route('admin.slides.index')
            ->with('success', 'Slide actualizado correctamente.');
    }

    // 6) Destroy: elimina un slide
    public function destroy(Slide $slide)
    {
        $this->borrarDeCloudinary($slide->imagen_ruta);
        $slide->delete();

        return back()->with('success', 'Slide eliminado correctamente.');
    }

    private function subirACloudinary($file, $folder = 'uh-luhmil-pakal/slides')
    {
        $timestamp = time();
        $apiSecret = env('CLOUDINARY_API_SECRET');
        $params_to_sign = "folder={$folder}&timestamp={$timestamp}";
        $signature = sha1($params_to_sign . $apiSecret);

        $response = Http::withOptions(['verify' => false])
            ->asMultipart()
            ->post("https://api.cloudinary.com/v1_1/" . env('CLOUDINARY_CLOUD_NAME') . "/image/upload", [
                ['name' => 'file', 'contents' => fopen($file->getRealPath(), 'r')],
                ['name' => 'api_key', 'contents' => env('CLOUDINARY_API_KEY')],
                ['name' => 'timestamp', 'contents' => $timestamp],
                ['name' => 'signature', 'contents' => $signature],
                ['name' => 'folder', 'contents' => $folder],
            ]);

        if ($response->failed()) {
            throw new \Exception('Cloudinary error: ' . $response->body());
        }

        return $response->json()['secure_url'];
    }

    private function borrarDeCloudinary($url)
    {
        $parsed = parse_url($url);
        if (!isset($parsed['path'])) return;

        $path = ltrim($parsed['path'], '/');
        $sinExtension = preg_replace('/\.[^.\s]{3,4}$/', '', $path);

        if (preg_match('/upload\/(?:v\d+\/)?(.+)/', $sinExtension, $matches)) {
            $publicId = $matches[1];
            $timestamp = time();
            $apiSecret = env('CLOUDINARY_API_SECRET');
            $params_to_sign = "public_id={$publicId}&timestamp={$timestamp}&type=upload";
            $signature = sha1($params_to_sign . $apiSecret);

            Http::withOptions(['verify' => false])
                ->asForm()
                ->post("https://api.cloudinary.com/v1_1/" . env('CLOUDINARY_CLOUD_NAME') . "/image/destroy", [
                    'api_key'   => env('CLOUDINARY_API_KEY'),
                    'timestamp' => $timestamp,
                    'signature' => $signature,
                    'public_id' => $publicId,
                    'type'      => 'upload',
                ]);
        }
    }
}
