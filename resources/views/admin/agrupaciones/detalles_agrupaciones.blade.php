@extends('layouts.admin')

@section('title', 'Detalle de Agrupación')

@section('content')
    @php
        $tab = request('tab', 'registradas');
    @endphp
    <div class="agrupacion-form-container">
        <div class="agrupacion-form-header">
            <h2>Detalles de la Agrupación</h2>
        </div>

        <div class="agrupacion-form-body">
            <div class="row">
                <div class="col-md-6">
                    <label class="agrupacion-form-label">Nombre de la Agrupación</label>
                    <input type="text" class="agrupacion-form-input" value="{{ $agrupacion->nombre_agrupacion }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label">Nombre del Representante</label>
                    <input type="text" class="agrupacion-form-input" value="{{ $agrupacion->nombre_representante }}"
                        readonly>
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label">Correo del Representante</label>
                    <input type="email" class="agrupacion-form-input" value="{{ $agrupacion->email_representante }}"
                        readonly>
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label">CURP del Representante</label>
                    <input type="text" class="agrupacion-form-input" value="{{ $agrupacion->curp_representante }}"
                        readonly>
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label">RFC de la Agrupación</label>
                    <input type="text" class="agrupacion-form-input" value="{{ $agrupacion->rfc_agrupacion }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label">Dirección</label>
                    <textarea class="agrupacion-form-input form-control" rows="2" readonly>{{ $agrupacion->direccion_agrupacion }}</textarea>
                </div>

                <div class="col-md-4">
                    <label class="agrupacion-form-label">Superficie de Cosecha (ha)</label>
                    <input type="text" class="agrupacion-form-input" value="{{ $agrupacion->superficie_cosecha }}"
                        readonly>
                </div>

                <div class="col-md-4">
                    <label class="agrupacion-form-label">Tipo de Suelo</label>
                    <input type="text" class="agrupacion-form-input" value="{{ $agrupacion->tipo_suelo }}" readonly>
                </div>

                <div class="col-md-4">
                    <label class="agrupacion-form-label">Número de Trabajadores</label>
                    <input type="text" class="agrupacion-form-input" value="{{ $agrupacion->num_trabajadores }}"
                        readonly>
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label">Tipo de Maquinaria</label>
                    <textarea class="agrupacion-form-input form-control" rows="2" readonly>{{ $agrupacion->tipo_maquinaria }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label">Horas de Trabajo</label>
                    <input type="text" class="agrupacion-form-input" value="{{ $agrupacion->horas_trabajo }}" readonly>
                </div>

                <div class="col-md-3">
                    <label class="agrupacion-form-label">Fecha de Inicio</label>
                    <input type="date" class="agrupacion-form-input" value="{{ $agrupacion->fecha_inicio }}" readonly>
                </div>

                <div class="col-md-3">
                    <label class="agrupacion-form-label">Fecha de Cosecha</label>
                    <input type="date" class="agrupacion-form-input" value="{{ $agrupacion->fecha_cosecha }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label">Estado actual</label>
                    <input type="text" class="agrupacion-form-input" value="{{ ucfirst($agrupacion->estado) }}"
                        readonly>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4 agrupacion-btn-group">
                <a href="{{ route('admin.agrupaciones.index', ['tab' => $tab]) }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
@endsection
