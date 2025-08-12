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
        $request->validate(
            [
                // Datos Generales
                'nombre_agrupacion'     => 'required|string|max:255',
                'nombre_representante'  => 'required|string|max:255',
                'email_representante' => 'required|email|max:255|unique:agrupaciones,email_representante',
                'curp_representante' => 'required|string|size:18|regex:/^[A-Z0-9]{18}$/|unique:agrupaciones,curp_representante',
                'rfc_agrupacion' => 'required|string|size:12|regex:/^[A-Z0-9]{12}$/|unique:agrupaciones,rfc_agrupacion',
                'direccion_agrupacion'  => 'required|string|max:255',
                'superficie_cosecha'    => 'required|numeric|min:0.1|max:50',
                'tipo_suelo'            => 'required|string|max:255',

                // Datos Específicos
                'num_trabajadores'      => 'required|integer|min:1|max:5000',
                'horas_trabajo'         => 'required|integer|min:1|max:168',
                'fecha_inicio'          => 'required|date|after_or_equal:2020-01-01|before_or_equal:2030-12-31',
                'fecha_cosecha'         => 'required|date|after_or_equal:fecha_inicio|before_or_equal:2030-12-31',
                'tipo_maquinaria' => 'required|array|min:1',
                'tipo_maquinaria.*' => 'in:Tractores,Aspersores,Sembradoras,Cosechadoras,Fumigadoras,Camiones,Mangueras de riego,Motores de riego',
            ],
            [
                // Mensajes personalizados
                'required' => 'El :attribute es obligatorio.',
                'string' => 'El campo :attribute debe ser texto.',
                'max' => 'El campo :attribute no debe exceder los :max caracteres.',
                'min' => 'El campo :attribute debe tener al menos :min.',
                'email' => 'El campo :attribute debe ser un correo válido.',
                'size' => 'El campo :attribute debe tener exactamente :size caracteres.',
                'regex' => 'El campo :attribute tiene un formato inválido.',
                'numeric' => 'El campo :attribute debe ser numérico.',
                'integer' => 'El campo :attribute debe ser un número entero.',
                'date' => 'El campo :attribute debe ser una fecha válida.',
                'after_or_equal' => 'La fecha de cosecha debe ser posterior o igual a la fecha de siembra.',

                // Excepciones femeninas específicas
                'horas_trabajo.required' => 'Las :attribute es obligatoria.',
                'fecha_inicio.required' => 'La :attribute es obligatoria.',
                'fecha_cosecha.required' => 'La :attribute es obligatoria.',
                'superficie_cosecha.required' => 'La :attribute es obligatoria.',
                'num_trabajadores.min' => 'Los :attribute no pueden ser menores a :min.',
                'num_trabajadores.max' => 'Los :attribute no pueden exceder los :max.',
                'horas_trabajo.min' => 'Las :attribute no pueden ser menores a :min horas.',
                'horas_trabajo.max' => 'Las :attribute no pueden exceder las :max horas.',
                'email_representante.unique' => 'El correo electrónico ya ha sido registrado.',
                'curp_representante.unique' => 'El CURP ya está registrado.',
                'rfc_agrupacion.unique' => 'El RFC ya está registrado.',


                'fecha_inicio.after_or_equal' => 'La fecha de siembra no puede ser anterior al año 2020.',
                'fecha_inicio.before_or_equal' => 'La fecha de siembra no puede ser posterior al año 2030.',
                'fecha_cosecha.before_or_equal' => 'La fecha de cosecha no puede ser posterior al año 2030.',
            ],
            [
                // Atributos personalizados
                'nombre_agrupacion' => 'nombre de la unidad',
                'nombre_representante' => 'nombre del representante',
                'email_representante' => 'correo electrónico',
                'curp_representante' => 'CURP del representante',
                'rfc_agrupacion' => 'RFC de la unidad',
                'direccion_agrupacion' => 'dirección de la unidad',
                'superficie_cosecha' => 'superficie de cosecha',
                'tipo_suelo' => 'tipo de suelo',
                'num_trabajadores' => 'número de trabajadores',
                'tipo_maquinaria' => 'tipo de maquinaria',
                'horas_trabajo' => 'horas de trabajo semanal',
                'fecha_inicio' => 'fecha de siembra',
                'fecha_cosecha' => 'fecha de cosecha',
            ]
        );

        // Convertir el array de tipo_maquinaria en string separado por comas
        $maquinarias = $request->input('tipo_maquinaria', []);
        $tipoMaquinariaStr = implode(', ', $maquinarias);
        $request->merge(['tipo_maquinaria' => $tipoMaquinariaStr]);

        Agrupacion::create($request->all());
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
}
