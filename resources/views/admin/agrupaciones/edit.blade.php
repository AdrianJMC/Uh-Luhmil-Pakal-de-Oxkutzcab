@extends('layouts.admin')

@section('content')
    <div class="agrupacion-form-container">
        <div class="agrupacion-form-header">
            <h2>Editar Agrupación</h2>
        </div>

        <form action="{{ route('admin.agrupaciones.update', $agrupacion->id) }}" method="POST" class="agrupacion-form-body">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <label class="agrupacion-form-label" for="nombre_agrupacion">Nombre de la agrupación</label>
                    <input type="text" name="nombre_agrupacion" class="agrupacion-form-input"
                        value="{{ $agrupacion->nombre_agrupacion }}">
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label" for="nombre_representante">Nombre del representante</label>
                    <input type="text" name="nombre_representante" class="agrupacion-form-input"
                        value="{{ $agrupacion->nombre_representante }}">
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label" for="email_representante">Correo del representante</label>
                    <input type="email" name="email_representante" class="agrupacion-form-input"
                        value="{{ $agrupacion->email_representante }}">
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label" for="curp_representante">CURP del representante</label>
                    <input type="text" name="curp_representante" class="agrupacion-form-input"
                        value="{{ $agrupacion->curp_representante }}">
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label" for="rfc_agrupacion">RFC de la agrupación</label>
                    <input type="text" name="rfc_agrupacion" class="agrupacion-form-input"
                        value="{{ $agrupacion->rfc_agrupacion }}">
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label" for="direccion_agrupacion">Dirección</label>
                    <input type="text" name="direccion_agrupacion" class="agrupacion-form-input"
                        value="{{ $agrupacion->direccion_agrupacion }}">
                </div>

                <div class="col-md-4">
                    <label class="agrupacion-form-label" for="superficie_cosecha">Superficie de cosecha (ha)</label>
                    <input type="text" name="superficie_cosecha" class="agrupacion-form-input"
                        value="{{ $agrupacion->superficie_cosecha }}">
                </div>

                <div class="col-md-4">
                    <label class="agrupacion-form-label" for="tipo_suelo">Tipo de suelo</label>
                    <input type="text" name="tipo_suelo" class="agrupacion-form-input"
                        value="{{ $agrupacion->tipo_suelo }}">
                </div>

                <div class="col-md-4">
                    <label class="agrupacion-form-label" for="num_trabajadores">Número de trabajadores</label>
                    <input type="number" name="num_trabajadores" class="agrupacion-form-input"
                        value="{{ $agrupacion->num_trabajadores }}">
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label" for="tipo_maquinaria">Tipo de maquinaria</label>
                    <input type="text" name="tipo_maquinaria" class="agrupacion-form-input"
                        value="{{ $agrupacion->tipo_maquinaria }}">
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label" for="horas_trabajo">Horas de trabajo por semana</label>
                    <input type="number" name="horas_trabajo" class="agrupacion-form-input"
                        value="{{ $agrupacion->horas_trabajo }}">
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label" for="certificaciones">Certificaciones</label>
                    <input type="text" name="certificaciones" class="agrupacion-form-input"
                        value="{{ $agrupacion->certificaciones }}">
                </div>

                <div class="col-md-3">
                    <label class="agrupacion-form-label" for="fecha_inicio">Fecha de inicio de siembra</label>
                    <input type="date" name="fecha_inicio" class="agrupacion-form-input"
                        value="{{ $agrupacion->fecha_inicio }}">
                </div>

                <div class="col-md-3">
                    <label class="agrupacion-form-label" for="fecha_cosecha">Fecha estimada de cosecha</label>
                    <input type="date" name="fecha_cosecha" class="agrupacion-form-input"
                        value="{{ $agrupacion->fecha_cosecha }}">
                </div>

                <div class="col-md-6">
                    <label class="agrupacion-form-label">Estado actual</label>
                    <input type="text" class="agrupacion-form-input" value="{{ ucfirst($agrupacion->estado) }}"
                        readonly>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4 agrupacion-btn-group">
                <a href="{{ route('admin.agrupaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-warning">Guardar cambios</button>
            </div>
        </form>
    </div>
@endsection
