<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CatalogoController extends Controller
{
    public function index()
    {
        // Trae los catálogos del más nuevo al más antiguo
        $catalogos = Catalogo::orderBy('created_at', 'desc')->paginate(15); // 12 por página
        return view('admin.catalogo.index', compact('catalogos'));
    }

    public function store(Request $request)
    {
        // 1) Creamos el validador
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'imagen.max' => 'La imagen no debe pesar más de 5 MB.',
        ]);

        // 2) Si falla, redirigimos con errores y flag
        if ($validator->fails()) {
            return redirect()
                ->route('admin.catalogos.index')
                ->withErrors($validator)
                ->withInput()
                ->with('create_error', true);
        }

        // 3) Obtenemos solo los datos validados
        $data = $validator->validated();

        // 4) Sube la imagen y añade al array
        $upload = $this->subirACloudinary($request->file('imagen'));
        $data['imagen_url']       = $upload['url'];
        $data['imagen_public_id'] = $upload['public_id'];

        // 5) Creamos el catálogo
        Catalogo::create([
            'nombre'            => $data['nombre'],
            'imagen_url'        => $data['imagen_url'],
            'imagen_public_id'  => $data['imagen_public_id'],
        ]);

        return redirect()
            ->route('admin.catalogos.index')
            ->with('catalogo_success', 'Catálogo creado correctamente.');
    }

    public function update(Request $request, Catalogo $catalogo)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'imagen.max' => 'La imagen no debe pesar más de 5 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.catalogos.index')
                ->withErrors($validator)
                ->with('edit_error_id', $catalogo->id)
                ->withInput();
        }

        // Si suben nueva imagen, primero borra la anterior
        if ($request->hasFile('imagen') && $catalogo->imagen_public_id) {
            $this->borrarDeCloudinary($catalogo->imagen_public_id);

            // luego sube la nueva
            $upload = $this->subirACloudinary($request->file('imagen'));
            $data['imagen_url']       = $upload['url'];
            $data['imagen_public_id'] = $upload['public_id'];
        }

        $catalogo->update($data);

        return back()->with('catalogo_success', 'Catálogo actualizado correctamente.');
    }

    public function destroy(Catalogo $catalogo)
    {
        // opcional: borra de Cloudinary antes de eliminar registro
        if ($catalogo->imagen_public_id) {
            $this->borrarDeCloudinary($catalogo->imagen_public_id);
        }
        $catalogo->delete();

        return back()->with('catalogo_success', 'Catálogo eliminado correctamente.');
    }

    /** Sube un archivo a Cloudinary y devuelve array con url + public_id */
    private function subirACloudinary($file, $folder = 'uh-luhmil-pakal/catalogos')
    {
        $timestamp = time();
        $signature = sha1("folder={$folder}&timestamp={$timestamp}" . env('CLOUDINARY_API_SECRET'));

        $response = Http::withOptions(['verify' => false])
            ->asMultipart()
            ->post("https://api.cloudinary.com/v1_1/" . env('CLOUDINARY_CLOUD_NAME') . "/image/upload", [
                ['name' => 'file',      'contents' => fopen($file->getRealPath(), 'r')],
                ['name' => 'api_key',   'contents' => env('CLOUDINARY_API_KEY')],
                ['name' => 'timestamp', 'contents' => $timestamp],
                ['name' => 'signature', 'contents' => $signature],
                ['name' => 'folder',    'contents' => $folder],
            ]);

        if ($response->failed()) {
            throw new \Exception('Cloudinary error: ' . $response->body());
        }

        $json = $response->json();
        return [
            'url'       => $json['secure_url'],
            'public_id' => $json['public_id'],
        ];
    }

    /** Borra de Cloudinary usando el public_id */
    private function borrarDeCloudinary(string $publicId)
    {
        $timestamp = time();
        $signature = sha1("public_id={$publicId}&timestamp={$timestamp}" . env('CLOUDINARY_API_SECRET'));

        Http::withOptions(['verify' => false])
            ->asForm()
            ->post("https://api.cloudinary.com/v1_1/" . env('CLOUDINARY_CLOUD_NAME') . "/image/destroy", [
                'public_id' => $publicId,
                'api_key'   => env('CLOUDINARY_API_KEY'),
                'timestamp' => $timestamp,
                'signature' => $signature,
            ]);
    }
}
