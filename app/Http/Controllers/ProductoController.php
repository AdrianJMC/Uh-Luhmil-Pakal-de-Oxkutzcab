<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Catalogo;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::where('agrupacion_id', auth('agrupacion')->id())->latest()->get();
        return view('agrupaciones.Apartados.Productos.productos', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unidades = [
            'kg',
            'gramos',
            'tonelada',
            'litro',
            'mililitro',
            'pieza',
            'docena',
            'manojo',
            'caja',
            'bulto',
            'saco',
            'paquete',
            'botella',
            'canastilla',
            'bandeja',
            'otros'
        ];

        // 1) Trae todos los catálogos
        $catalogos = Catalogo::orderBy('nombre')->get(['id', 'nombre']);

        return view(
            'agrupaciones.Apartados.Productos.Acciones.crear-producto',
            compact('unidades', 'catalogos')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'catalogo_id' => 'required|exists:catalogos,id',
            'precio' => 'required|numeric|min:0.01',
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'foto.required' => 'La imagen del producto es obligatoria.',
            'foto.image' => 'El archivo debe ser una imagen válida.',
            'foto.mimes' => 'Solo se permiten imágenes en formato jpg, jpeg, png o webp.',
            'foto.max' => 'La imagen no debe pesar más de 5 MB.',
        ]);

        try {
            if (!$request->hasFile('foto') || !$request->file('foto')->isValid()) {
                return back()->withErrors(['foto' => 'La imagen no se subió correctamente.'])->withInput();
            }

            $imagenUrl = $this->subirACloudinary($request->file('foto'));

            // 🟢 Obtiene el nombre del catálogo
            $catalogo = Catalogo::findOrFail($request->catalogo_id);

            Producto::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'categoria' => $catalogo->nombre, // 🟢 Guarda el nombre como texto
                'catalogo_id' => $catalogo->id,
                'precio' => $request->precio,
                'imagen' => $imagenUrl,
                'agrupacion_id' => auth('agrupacion')->id(),
                'estado' => 'pendiente_aprobacion',
            ]);

            return redirect()->route('agrupaciones.productos.index')->with('success', 'Producto registrado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['foto' => 'Ocurrió un error al subir la imagen: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $unidades = [
            'kg',
            'gramos',
            'tonelada',
            'litro',
            'mililitro',
            'pieza',
            'docena',
            'manojo',
            'caja',
            'bulto',
            'saco',
            'paquete',
            'botella',
            'canastilla',
            'bandeja',
            'otros'
        ];

        // Catálogos para el dropdown
        $catalogos = Catalogo::orderBy('nombre')->get(['id', 'nombre']);

        return view('agrupaciones.Apartados.Productos.Acciones.editar-producto', compact('producto', 'catalogos', 'unidades'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0.01',
            'catalogo_id' => 'required|exists:catalogos,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'foto.image' => 'El archivo debe ser una imagen válida.',
            'foto.mimes' => 'Solo se permiten imágenes en formato jpg, jpeg, png o webp.',
            'foto.max' => 'La imagen no debe pesar más de 5 MB.',
        ]);

        try {
            // 🟢 Obtener el catálogo seleccionado
            $catalogo = Catalogo::findOrFail($request->catalogo_id);

            $data = [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'categoria' => $catalogo->nombre, // 🟢 Aquí se guarda el nombre
                'precio' => $request->precio,
                'catalogo_id' => $catalogo->id,
            ];

            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                $this->borrarDeCloudinary($producto->imagen);
                $data['imagen'] = $this->subirACloudinary($request->file('foto'));
            }

            if ($producto->estado === 'rechazado') {
                $data['estado'] = 'pendiente_aprobacion';
                $data['motivo_rechazo'] = null;
            }

            $producto->update($data);

            return redirect()->route('agrupaciones.productos.index')->with('success', 'Producto actualizado y enviado a revisión.');
        } catch (\Exception $e) {
            return back()->withErrors(['foto' => 'Ocurrió un error: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        try {
            $this->borrarDeCloudinary($producto->imagen);
            $producto->delete();

            return redirect()->route('agrupaciones.productos.index')->with('success', 'Producto eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('agrupaciones.productos.index')->withErrors(['error' => 'Error al eliminar el producto: ' . $e->getMessage()]);
        }
    }


    //funciones de cloudinary
    private function subirACloudinary($file, $folder = 'uh-luhmil-pakal/productos')
    {
        $timestamp = time();
        $apiSecret = env('CLOUDINARY_API_SECRET');
        $transformation = 'c_limit,w_1000,h_1000,f_auto,q_auto';

        $params_to_sign = "folder={$folder}&timestamp={$timestamp}&transformation={$transformation}";
        $signature = sha1($params_to_sign . $apiSecret);

        $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
            ->asMultipart()
            ->post("https://api.cloudinary.com/v1_1/" . env('CLOUDINARY_CLOUD_NAME') . "/image/upload", [
                ['name' => 'file', 'contents' => fopen($file->getRealPath(), 'r')],
                ['name' => 'api_key', 'contents' => env('CLOUDINARY_API_KEY')],
                ['name' => 'timestamp', 'contents' => $timestamp],
                ['name' => 'signature', 'contents' => $signature],
                ['name' => 'folder', 'contents' => $folder],
                ['name' => 'transformation', 'contents' => $transformation],
            ]);

        if ($response->failed()) {
            throw new \Exception('Cloudinary error: ' . $response->body());
        }

        return $response->json()['secure_url'];
    }

    //eliminar o reemplazar imagen de cloudinary
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

            \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
                ->asForm()
                ->post(
                    "https://api.cloudinary.com/v1_1/" . env('CLOUDINARY_CLOUD_NAME') . "/image/destroy",
                    [
                        'api_key'   => env('CLOUDINARY_API_KEY'),
                        'timestamp' => $timestamp,
                        'signature' => $signature,
                        'public_id' => $publicId,
                        'type'      => 'upload',
                    ]
                );
        }
    }
}
