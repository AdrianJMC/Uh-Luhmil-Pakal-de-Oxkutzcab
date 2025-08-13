<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
                'video_id' => ['required', 'url', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be|vimeo\.com)\//i'],
                'imagen_video' => 'nullable|image|max:5120|mimes:jpeg,png,webp|dimensions:min_width=300,min_height=300,max_width=1500,max_height=1500',
                'orden' => ['required', 'integer', 'between:1,4', Rule::unique('infos', 'orden')],
            ], [
                'video_id.required' => 'El enlace del video es obligatorio.',
                'video_id.url'      => 'Debes pegar un enlace válido.',
                'video_id.regex'    => 'Solo se aceptan enlaces de YouTube o Vimeo.',
                'imagen_video.image' => 'La miniatura debe ser una imagen válida.',
                'imagen_video.max' => 'La miniatura no debe superar los 5 MB.',
                'imagen_video.mimes' => 'Solo se permiten imágenes JPEG, PNG o WEBP.',
                'imagen_video.dimensions' => 'La imagen debe tener entre 300x300 y 1500x1500 píxeles.',
                'orden.required' => 'El campo orden es obligatorio.',
                'orden.integer'  => 'El orden debe ser un número entero.',
                'orden.between'  => 'El orden debe estar entre 1 y 4.',
                'orden.unique'   => 'Ese orden ya está asignado a otra tarjeta. Elige otro número.',
            ]);

            // Guarda el enlace tal cual:
            $videoUrl = $data['video_id']; // ahora es un URL, no un ID

            $imagenUrl = null;
            if ($request->hasFile('imagen_video')) {
                $imagenUrl = $this->subirACloudinary($request->file('imagen_video'));
            }

            Info::create([
                'titulo'      => null,
                'texto'       => null,
                'video_id'    => $videoUrl,  // 👈 guardas embed listo
                'imagen_ruta' => $imagenUrl,  // si hay miniatura
                'orden'       => $data['orden'],
            ]);
        } else {
            $data = $request->validate([
                'titulo'        => 'required|string|min:5|max:255',
                'texto'         => 'required|string|min:10',
                'imagen_normal' => 'required|image|max:5120|mimes:jpeg,png,webp|dimensions:min_width=300,min_height=300,max_width=1500,max_height=1500',
                'orden' => [
                    'required',
                    'integer',
                    'between:1,4',
                    Rule::unique('infos', 'orden'),
                ],
            ], [
                'titulo.required' => 'El título es obligatorio.',
                'titulo.min' => 'El título debe tener al menos :min caracteres.',
                'texto.required' => 'El texto es obligatorio.',
                'texto.min' => 'El texto debe tener al menos :min caracteres.',
                'imagen_normal.required' => 'Debes subir una imagen.',
                'imagen_normal.image' => 'El archivo debe ser una imagen válida.',
                'imagen_normal.max' => 'La imagen no debe superar los 5 MB.',
                'imagen_normal.mimes' => 'Solo se permiten imágenes JPEG, PNG o WEBP.',
                'imagen_normal.dimensions' => 'La imagen debe tener entre 300x300 y 1500x1500 píxeles.',
                'orden.required' => 'El campo orden es obligatorio.',
                'orden.integer' => 'El orden debe ser un número entero.',
                'orden.min' => 'El orden mínimo permitido es :min.',
                'orden.max' => 'El orden máximo permitido es :max.',
                'orden.unique' => 'Ese orden ya está asignado a otra tarjeta. Elige otro número.',
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
                'video_id' => [
                    'required',
                    'url',
                    'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be|vimeo\.com)\//i'
                ],
                'orden' => [
                    'required',
                    'integer',
                    'between:1,4',
                    Rule::unique('infos', 'orden')->ignore($info->id),
                ],
                'imagen_video' => 'nullable|image|max:5120|mimes:jpeg,png,webp|dimensions:min_width=300,min_height=300,max_width=1500,max_height=1500',
            ], [
                'video_id.required' => 'El enlace del video es obligatorio.',
                'video_id.url'      => 'Debes pegar un enlace válido.',
                'video_id.regex'    => 'Solo se aceptan enlaces de YouTube o Vimeo.',
                'imagen_video.image' => 'La miniatura debe ser una imagen válida.',
                'imagen_video.max' => 'La miniatura no debe superar los 5 MB.',
                'imagen_video.mimes' => 'Solo se permiten imágenes JPEG, PNG o WEBP.',
                'imagen_video.dimensions' => 'La imagen debe tener entre 300x300 y 1500x1500 píxeles.',
                'orden.required' => 'El campo orden es obligatorio.',
                'orden.integer' => 'El orden debe ser un número entero.',
                'orden.min' => 'El orden mínimo permitido es :min.',
                'orden.max' => 'El orden máximo permitido es :max.',
                'orden.between' => 'El orden debe estar entre 1 y 4.',
                'orden.unique'  => 'Ese orden ya está asignado a otra tarjeta. Elige otro número.',
            ]);

            // Guarda el enlace tal cual:
            $videoUrl = $data['video_id']; // ahora es un URL, no un ID

            $imagenUrl = $info->imagen_ruta;
            if ($request->hasFile('imagen_video')) {
                $this->borrarDeCloudinary($info->imagen_ruta);
                $imagenUrl = $this->subirACloudinary($request->file('imagen_video'));
            }

            $info->update([
                'titulo'      => null,
                'texto'       => null,
                'video_id'    => $videoUrl,   // 👈 guardar embed
                'imagen_ruta' => $imagenUrl,
                'orden'       => $data['orden'],
            ]);
        } else {
            $data = $request->validate([
                'titulo'        => 'required|string|max:255',
                'texto'         => 'required|string',
                'orden' => [
                    'required',
                    'integer',
                    'between:1,4',
                    Rule::unique('infos', 'orden')->ignore($info->id),
                ],
                'imagen_normal' => 'nullable|image|max:5120|mimes:jpeg,png,webp|dimensions:min_width=300,min_height=300,max_width=1500,max_height=1500',
            ], [
                'titulo.required' => 'El título es obligatorio.',
                'titulo.min' => 'El título debe tener al menos :min caracteres.',
                'texto.required' => 'El texto es obligatorio.',
                'texto.min' => 'El texto debe tener al menos :min caracteres.',
                'imagen_normal.required' => 'Debes subir una imagen.',
                'imagen_normal.image' => 'El archivo debe ser una imagen válida.',
                'imagen_normal.max' => 'La imagen no debe superar los 5 MB.',
                'imagen_normal.mimes' => 'Solo se permiten imágenes JPEG, PNG o WEBP.',
                'imagen_normal.dimensions' => 'La imagen debe tener entre 300x300 y 1500x1500 píxeles.',
                'orden.required' => 'El campo orden es obligatorio.',
                'orden.integer' => 'El orden debe ser un número entero.',
                'orden.min' => 'El orden mínimo permitido es :min.',
                'orden.max' => 'El orden máximo permitido es :max.',
                'orden.unique' => 'Ese orden ya está asignado a otra tarjeta. Elige otro número.',
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

    private function toEmbedUrl(string $input): ?string
    {
        $input = trim($input);

        // ---- YOUTUBE ----
        // Caso ID directo (11 chars)
        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $input)) {
            return "https://www.youtube.com/embed/{$input}";
        }
        // URL completas comunes
        if (preg_match('~(youtu\.be/|youtube\.com)~i', $input)) {
            $url = $input;
            // Normaliza
            $parts = parse_url($url);
            $host  = $parts['host'] ?? '';
            $path  = $parts['path'] ?? '';
            parse_str($parts['query'] ?? '', $q);

            // youtu.be/VIDEOID
            if (stripos($host, 'youtu.be') !== false) {
                $id = ltrim($path, '/');
                $id = preg_replace('/[^A-Za-z0-9_-]/', '', $id);
                return strlen($id) === 11 ? "https://www.youtube.com/embed/{$id}" : null;
            }

            // youtube.com/watch?v=VIDEOID
            if (isset($q['v']) && preg_match('/^[A-Za-z0-9_-]{11}$/', $q['v'])) {
                return "https://www.youtube.com/embed/{$q['v']}";
            }

            // /embed/VIDEOID  o  /shorts/VIDEOID
            if (preg_match('~/(embed|shorts)/([A-Za-z0-9_-]{11})~', $path, $m)) {
                return "https://www.youtube.com/embed/{$m[2]}";
            }
        }

        // ---- VIMEO ----
        if (preg_match('~vimeo\.com~i', $input)) {
            $parts = parse_url($input);
            $path  = $parts['path'] ?? '';
            // player.vimeo.com/video/ID  o  vimeo.com/ID  o otras rutas que terminan en /ID
            if (preg_match('~/video/(\d+)~', $path, $m) || preg_match('~/(\d+)$~', $path, $m)) {
                return "https://player.vimeo.com/video/{$m[1]}";
            }
        }
        // Caso ID numérico de Vimeo “pelón”
        if (preg_match('/^\d{6,}$/', $input)) {
            return "https://player.vimeo.com/video/{$input}";
        }

        return null;
    }
}
