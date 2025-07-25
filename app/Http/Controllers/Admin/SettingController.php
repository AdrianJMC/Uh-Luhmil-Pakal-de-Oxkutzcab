<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SettingController extends Controller
{
    /**
     * Subida manual a Cloudinary (sin SDK)
     */
    private function cloudinaryUpload($file)
    {
        $timestamp = time();
        $apiSecret = env('CLOUDINARY_API_SECRET');

        $params_to_sign = "folder=uh-luhmil-pakal/settings&timestamp={$timestamp}";
        $signature = sha1($params_to_sign . $apiSecret);

        // ❗ Desactivar SSL (solo para entorno local)
        $response = Http::withOptions(['verify' => false])
            ->asMultipart()
            ->post("https://api.cloudinary.com/v1_1/" . env('CLOUDINARY_CLOUD_NAME') . "/image/upload", [
                ['name' => 'file', 'contents' => fopen($file->getRealPath(), 'r')],
                ['name' => 'api_key', 'contents' => env('CLOUDINARY_API_KEY')],
                ['name' => 'timestamp', 'contents' => $timestamp],
                ['name' => 'signature', 'contents' => $signature],
                ['name' => 'folder', 'contents' => 'uh-luhmil-pakal/settings'],
            ]);

        if ($response->failed()) {
            throw new \Exception("Error al subir a Cloudinary: " . $response->body());
        }

        return $response->json()['secure_url'];
    }

    public function editLogo()
    {
        $logo = optional(Setting::firstWhere('key', 'logo'))->value;
        return view('admin.settings.logo', compact('logo'));
    }

    public function updateLogo(Request $req)
    {
        try {
            $req->validate([
                'logo' => ['required', 'image', 'max:2048', 'dimensions:max_width=500,max_height=500'],
            ]);

            $file = $req->file('logo');

            // 🔍 Obtener URL actual del logo
            $oldUrl = Setting::getValue('logo');
            if ($oldUrl) {
                // 🧠 Extraer public_id del logo anterior
                $parsed = parse_url($oldUrl);
                $path = ltrim($parsed['path'], '/');
                $publicId = pathinfo($path, PATHINFO_FILENAME);

                // ⚠️ Eliminar anterior logo (sin SDK, usando la API)
                $timestamp = time();
                $apiSecret = env('CLOUDINARY_API_SECRET');
                $toSign = "public_id=uh-luhmil-pakal/settings/{$publicId}&timestamp={$timestamp}";
                $signature = sha1($toSign . $apiSecret);

                Http::withOptions(['verify' => false])
                    ->asForm()
                    ->post("https://api.cloudinary.com/v1_1/" . env('CLOUDINARY_CLOUD_NAME') . "/image/destroy", [
                        'public_id' => "uh-luhmil-pakal/settings/{$publicId}",
                        'api_key' => env('CLOUDINARY_API_KEY'),
                        'timestamp' => $timestamp,
                        'signature' => $signature,
                    ]);
            }

            // 📤 Subir nuevo logo
            $url = $this->cloudinaryUpload($file);

            // 💾 Guardar en la base de datos
            Setting::updateOrCreate(['key' => 'logo'], ['value' => $url]);

            return redirect()
                ->route('admin.settings.logo.edit')
                ->with('success', 'Logo actualizado correctamente');
        } catch (\Exception $e) {
            dd("⚠️ Error al subir: " . $e->getMessage());
        }
    }
}
