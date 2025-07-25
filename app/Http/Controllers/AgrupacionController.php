<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAgrupacionRequest;
use App\Models\Agrupacion;
use App\Mail\NotificacionAgrupacion;
use Illuminate\Support\Facades\Mail;
use App\Services\BrevoService; // Asegúrate de que este servicio esté correctamente configurado
use Illuminate\Support\Facades\Http;
use App\Services\SupabaseStorageService;


class AgrupacionController extends Controller
{

    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $agrupacionesRegistradas = Agrupacion::where('estado', 'aprobado')
            ->when($buscar, function ($query, $buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre_agrupacion', 'like', "%$buscar%")
                        ->orWhere('nombre_representante', 'like', "%$buscar%")
                        ->orWhere('email_representante', 'like', "%$buscar%");
                });
            })
            ->latest()
            ->paginate(25, ['*'], 'registradas_page');

        $agrupacionesPendientes = Agrupacion::where('estado', 'pendiente')
            ->when($buscar, function ($query, $buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre_agrupacion', 'like', "%$buscar%")
                        ->orWhere('nombre_representante', 'like', "%$buscar%")
                        ->orWhere('email_representante', 'like', "%$buscar%");
                });
            })
            ->latest()
            ->paginate(25, ['*'], 'pendientes_page');

        return view('admin.agrupaciones.index', compact('agrupacionesRegistradas', 'agrupacionesPendientes'));
    }


    //Registro de agrupaciones
    public function create()
    {
        return view('agrupaciones.registro');
    }


    public function store(Request $request)
    {
        sleep(5); // Simula que tarda 2 segundos en procesar

        $request->validate([
            'nombre_agrupacion'     => 'required|string|max:255',
            'nombre_representante'  => 'required|string|max:255',
            'email_representante'   => 'required|email|max:255',
            'certificaciones.*'     => 'file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('certificaciones') && count($request->file('certificaciones')) > 5) {
            return back()->withErrors([
                'certificados' => 'Solo puedes subir hasta 5 documentos como máximo.',
            ])->withInput();
        }

        $storage     = new SupabaseStorageService();
        $urlsBase64  = [];

        if ($request->hasFile('certificaciones')) {
            foreach ($request->file('certificaciones') as $archivo) {
                try {
                    $nombreFinal    = uniqid('cert_', true) . '.' . $archivo->getClientOriginalExtension();
                    $url            = $storage->subirArchivo($archivo, $nombreFinal);
                    $urlsBase64[]   = base64_encode($url);
                } catch (\Exception $e) {
                    return back()->withErrors([
                        'certificados' => 'Error al subir uno de los archivos: ' . $e->getMessage(),
                    ])->withInput();
                }
            }
        }

        Agrupacion::create([
            ...$request->except('certificaciones'),
            // Aquí Eloquent convertirá automáticamente $urlsBase64 en JSON válido
            'certificaciones' => $urlsBase64,
        ]);

        return redirect()->route('agrupaciones.create')->with('success', true);
    }

    //aprobar agurpaciones
    public function aprobar($id)
    {
        $agrupacion = Agrupacion::findOrFail($id);
        $agrupacion->estado = 'aprobado';
        $agrupacion->save();

        $brevo = new BrevoService();
        $emailsEnviadosHoy = $brevo->correosEnviadosHoy();

        if ($emailsEnviadosHoy >= 300) {
            \App\Models\EmailPendiente::create([
                'to' => $agrupacion->email_representante,
                'subject' => 'Agrupación aprobada',
                'body' => view('emails.aprobacion', ['agrupacion' => $agrupacion, 'tipo' => 'aprobado'])->render(),
                'send_at' => now()->addDay(),
            ]);
        } else {
            $brevo->enviarNotificacionDesdeBlade($agrupacion, 'aprobado');
        }

        return redirect()->back()->with('success', 'Agrupación aprobada correctamente.');
    }


    //rechazar agrupaciones
    public function rechazar($id)
    {
        $agrupacion = Agrupacion::findOrFail($id);
        $datosParaCorreo = $agrupacion->toArray();
        $agrupacion->delete();

        $brevo = new BrevoService();
        $emailsEnviadosHoy = $brevo->correosEnviadosHoy();

        if ($emailsEnviadosHoy >= 300) {
            \App\Models\EmailPendiente::create([
                'to' => $datosParaCorreo['email_representante'],
                'subject' => 'Agrupación rechazada',
                'body' => view('emails.aprobacion', ['agrupacion' => (object)$datosParaCorreo, 'tipo' => 'rechazado'])->render(),
                'send_at' => now()->addDay(),
            ]);
        } else {
            $brevo->enviarNotificacionDesdeBlade((object)$datosParaCorreo, 'rechazado');
        }

        return redirect()->route('admin.agrupaciones.index', ['tab' => 'pendientes'])
            ->with('success', 'La solicitud fue rechazada y eliminada correctamente.');
    }


    // Mostrar formulario de edición
    public function edit(Agrupacion $agrupacion)
    {
        return view('admin.agrupaciones.edit', compact('agrupacion'));
    }

    // Guardar cambios después de la edición
    public function update(Request $request, Agrupacion $agrupacion)
    {
        $request->validate([
            'nombre_agrupacion' => 'required|string|max:255',
            'nombre_representante' => 'required|string|max:255',
            'email_representante' => 'required|email|max:255',
        ]);

        $agrupacion->update($request->all());

        return redirect()->route('admin.agrupaciones.index')
            ->with('success', 'Agrupación actualizada correctamente.');
    }

    // Eliminar agrupación
    public function destroy($id)
    {
        $agrupacion = Agrupacion::findOrFail($id);
        $agrupacion->delete();

        return redirect()->route('admin.agrupaciones.index')
            ->with('success', 'Agrupación eliminada correctamente.');
    }

    // Mostrar detalles de la agrupación
    public function show($id)
    {
        $agrupacion = Agrupacion::findOrFail($id);
        return view('admin.agrupaciones.detalles_agrupaciones', compact('agrupacion'));
    }

    /*
    private function subirDocumentoCloudinary($file)
    {
        // Validar por MIME TYPE real (más seguro que la extensión)
        if ($file->getClientMimeType() !== 'application/pdf') {
            throw new \Exception('Solo se permiten archivos PDF.');
        }

        $folder = 'uh-luhmil-pakal/certificaciones';
        $timestamp = time();
        $apiSecret = env('CLOUDINARY_API_SECRET');

        $nombreOriginal = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $publicId = $nombreOriginal . '-' . uniqid(); // sin extensión

        // Firma SIN 'resource_type'
        $params_to_sign = "folder={$folder}&public_id={$publicId}&timestamp={$timestamp}";
        $signature = sha1($params_to_sign . $apiSecret);

        $http = \Illuminate\Support\Facades\Http::asMultipart();
        if (app()->environment('local')) {
            $http = $http->withoutVerifying();
        }

        $response = $http->post("https://api.cloudinary.com/v1_1/" . env('CLOUDINARY_CLOUD_NAME') . "/raw/upload", [ // ✅ auto/upload
            ['name' => 'file', 'contents' => fopen($file->getRealPath(), 'r')],
            ['name' => 'api_key', 'contents' => env('CLOUDINARY_API_KEY')],
            ['name' => 'timestamp', 'contents' => $timestamp],
            ['name' => 'signature', 'contents' => $signature],
            ['name' => 'folder', 'contents' => $folder],
            ['name' => 'public_id', 'contents' => $publicId],
            // ❌ NO pongas 'resource_type', Cloudinary lo detecta automáticamente
        ]);

        if ($response->failed()) {
            throw new \Exception('Error al subir a Cloudinary: ' . $response->body());
        }

        return $response->json()['secure_url']; // URL directa y visualizable
    }

    //metodo para descargar certificaciónes
    public function descargarCertificacion($encoded)
    {
        $url = base64_decode($encoded);

        // Descargar el archivo temporalmente
        $contenido = file_get_contents($url);

        if ($contenido === false) {
            abort(404, 'No se pudo obtener el archivo.');
        }

        $nombre = basename(parse_url($url, PHP_URL_PATH));

        return response($contenido)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $nombre . '"');
    }*/
}
