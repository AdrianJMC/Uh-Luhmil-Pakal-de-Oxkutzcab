<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SupabaseStorageService
{
    protected $baseUrl;
    protected $apiKey;
    protected $bucket;

    public function __construct()
    {
        $this->baseUrl = env('SUPABASE_URL') . '/storage/v1';
        $this->apiKey = env('SUPABASE_SERVICE_KEY');
        $this->bucket = 'certificaciones'; // nombre del bucket
    }

    public function subirArchivo($file, $nombreFinal)
    {
        $path     = $this->bucket . '/' . $nombreFinal;
        $contents = file_get_contents($file->getRealPath());
        $response = Http::withHeaders([
            'apikey'        => $this->apiKey,
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => $file->getMimeType(),
        ])->put($this->baseUrl . "/object/$path", $contents);

        // === DEBUG ===
        dd([
            'endpoint' => $this->baseUrl . "/object/$path",
            'status'   => $response->status(),
            'body'     => $response->body(),
        ]);
        // =============

        if ($response->failed()) {
            throw new \Exception('Error al subir a Supabase: ' . $response->body());
        }

        return $this->generarUrlPublica($nombreFinal);
    }



    public function generarUrlPublica($nombreArchivo)
    {
        return env('SUPABASE_URL') . "/storage/v1/object/public/{$this->bucket}/{$nombreArchivo}";
    }
}
