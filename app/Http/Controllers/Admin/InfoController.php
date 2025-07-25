<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class InfoController extends Controller
{
    private function subirACloudinary($file, $folder = 'uh-luhmil-pakal/infos')
    {
        $timestamp = time();
        $apiSecret = env('CLOUDINARY_API_SECRET');
        $params_to_sign = "folder={$folder}&timestamp={$timestamp}";
        $signature = sha1($params_to_sign . $apiSecret);

        $response = Http::withOptions(['verify' => false]) // SSL desactivado en local
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

    public function index()
    {
        $infos = Info::orderBy('orden')->get();
        return view('admin.infos.index', compact('infos'));
    }

    public function create()
    {
        $infoCount = Info::count();
        return view('admin.infos.create', compact('infoCount'));
    }

    public function store(Request $request)
    {
        if (Info::count() >= 4) {
            return redirect()
                ->route('admin.infos.index')
                ->with('error', 'No puedes crear más de 4 informaciónes.');
        }

        $esVideo = $request->has('is_video');

        if ($esVideo) {
            $data = $request->validate([
                'video_id'     => 'required|string|max:255',
                'imagen_video' => 'nullable|image|max:5120',
                'orden'        => 'required|integer',
            ]);

            $imagenUrl = null;
            if ($request->hasFile('imagen_video')) {
                $imagenUrl = $this->subirACloudinary($request->file('imagen_video'));
            }

            Info::create([
                'titulo'      => null,
                'texto'       => null,
                'video_id'    => $data['video_id'],
                'imagen_ruta' => $imagenUrl,
                'orden'       => $data['orden'],
            ]);
        } else {
            $data = $request->validate([
                'titulo'        => 'required|string|max:255',
                'texto'         => 'required|string',
                'imagen_normal' => 'required|image|max:5120',
                'orden'         => 'required|integer',
            ]);

            $imagenUrl = $this->subirACloudinary($request->file('imagen_normal'));

            Info::create([
                'titulo'      => $data['titulo'],
                'texto'       => $data['texto'],
                'video_id'    => null,
                'imagen_ruta' => $imagenUrl,
                'orden'       => $data['orden'],
            ]);
        }

        return redirect()->route('admin.infos.index')->with('success', 'Info creada correctamente.');
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

            $imagenUrl = $info->imagen_ruta;
            if ($request->hasFile('imagen_video')) {
                $this->borrarDeCloudinary($info->imagen_ruta);
                $imagenUrl = $this->subirACloudinary($request->file('imagen_video'));
            }

            $info->update([
                'titulo'      => null,
                'texto'       => null,
                'video_id'    => $data['video_id'],
                'imagen_ruta' => $imagenUrl,
                'orden'       => $data['orden'],
            ]);
        } else {
            $data = $request->validate([
                'titulo'        => 'required|string|max:255',
                'texto'         => 'required|string',
                'imagen_normal' => 'nullable|image|max:5120',
                'orden'         => 'required|integer',
            ]);

            $imagenUrl = $info->imagen_ruta;
            if ($request->hasFile('imagen_normal')) {
                // 🔥 Borra la imagen anterior en Cloudinary
                $this->borrarDeCloudinary($info->imagen_ruta);

                // 🚀 Sube la nueva imagen
                $imagenUrl = $this->subirACloudinary($request->file('imagen_normal'));
            }

            $info->update([
                'titulo'      => $data['titulo'],
                'texto'       => $data['texto'],
                'video_id'    => null,
                'imagen_ruta' => $imagenUrl,
                'orden'       => $data['orden'],
            ]);
        }

        return back()->with('success', 'Info actualizada correctamente.');
    }

    public function destroy(Info $info)
    {
        // Eliminar imagen en Cloudinary si existe
        if ($info->imagen_ruta) {
            $publicId = $this->extraerPublicId($info->imagen_ruta);
            logger('📎 Public ID extraído: ' . $publicId);

            if ($publicId) {
                $timestamp = time();
                $apiSecret = env('CLOUDINARY_API_SECRET');
                $params_to_sign = "public_id={$publicId}&timestamp={$timestamp}&type=upload";
                $signature = sha1($params_to_sign . $apiSecret);

                $response = Http::withOptions(['verify' => false])
                    ->asForm()
                    ->post("https://api.cloudinary.com/v1_1/" . env('CLOUDINARY_CLOUD_NAME') . "/image/destroy", [
                        'api_key'    => env('CLOUDINARY_API_KEY'),
                        'timestamp'  => $timestamp,
                        'signature'  => $signature,
                        'public_id'  => $publicId,
                        'type'       => 'upload', // SÍ se envía aquí, pero NO en la firma
                    ]);

                logger('🧨 Cloudinary DELETE response: ' . $response->body());
            }
        }

        $info->delete();
        return back()->with('success', 'Info eliminada correctamente.');
    }

    private function extraerPublicId($url)
    {
        $parsed = parse_url($url);
        if (!isset($parsed['path'])) return null;

        $path = ltrim($parsed['path'], '/'); // Elimina barra inicial

        // Remueve extensión (.jpg, .png, etc.)
        $sinExtension = preg_replace('/\.[^.\s]{3,4}$/', '', $path);

        // Encuentra 'upload/' y corta después de eso
        if (preg_match('/upload\/(?:v\d+\/)?(.+)/', $sinExtension, $matches)) {
            return $matches[1]; // Esto da el public_id sin versión
        }

        return null;
    }

    private function borrarDeCloudinary($url)
    {
        $publicId = $this->extraerPublicId($url);
        logger('🧼 Borrando imagen previa: ' . $publicId);

        if ($publicId) {
            $timestamp = time();
            $apiSecret = env('CLOUDINARY_API_SECRET');
            $params_to_sign = "public_id={$publicId}&timestamp={$timestamp}&type=upload";
            $signature = sha1($params_to_sign . $apiSecret);

            $response = Http::withOptions(['verify' => false])
                ->asForm()
                ->post("https://api.cloudinary.com/v1_1/" . env('CLOUDINARY_CLOUD_NAME') . "/image/destroy", [
                    'api_key'   => env('CLOUDINARY_API_KEY'),
                    'timestamp' => $timestamp,
                    'signature' => $signature,
                    'public_id' => $publicId,
                    'type'      => 'upload',
                ]);

            logger('🧨 Cloudinary DELETE response (update): ' . $response->body());
        }
    }
}
