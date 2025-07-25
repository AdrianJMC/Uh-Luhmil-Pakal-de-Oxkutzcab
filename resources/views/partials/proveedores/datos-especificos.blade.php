{{-- =========================================
     COLUMNA DERECHA (Datos Específicos)
========================================= --}}
<div class="col-md-6" id="bloque-especificos">
    <h3 class="font-weight-bold titulo-datos mb-2" style="font-size: 3.5rem;">Datos Específicos</h3>

    <div class="row">
        <div class="form-group col-md-6 mb-0">
            <label for="num_trabajadores">Número de Trabajadores</label>
            <input type="number" min="1" name="num_trabajadores" id="num_trabajadores"
                class="form-control @error('num_trabajadores') is-invalid @enderror" placeholder="Ingresa la cantidad"
                value="{{ old('num_trabajadores') }}">
            @error('num_trabajadores')
                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">
                    {{ $message }}
                </div>
            @enderror
        </div>


        <div class="form-group col-md-6 mb-0">
            <label for="tipo_maquinaria">Tipo de maquinaria usada</label>
            <input type="text" name="tipo_maquinaria" id="tipo_maquinaria"
                class="form-control @error('tipo_maquinaria') is-invalid @enderror"
                placeholder="Ej. Tractores, aspersores..." value="{{ old('tipo_maquinaria') }}">
            @error('tipo_maquinaria')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6 mb-0">
            <label for="horas_trabajo">Horas trabajo semanal</label>
            <input type="number" min="1" name="horas_trabajo" id="horas_trabajo"
                class="form-control @error('horas_trabajo') is-invalid @enderror" placeholder="Ej. 40"
                value="{{ old('horas_trabajo') }}">
            @error('horas_trabajo')
                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group col-md-12 mb-0">
            <label for="certificados">Subir Certificaciones (PDF o Word, máximo 5)</label>
            <input type="file" name="certificaciones[]" id="certificados"
                class="form-control @error('certificados') is-invalid @enderror"
                accept=".pdf,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                multiple>

            @error('certificados')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row mb-0 grupo-calendarios">
        <div class="form-group col-md-6">
            <label for="fecha_inicio">Fecha de Siembra</label>
            <input type="text" name="fecha_inicio" id="fecha_inicio"
                class="form-control @error('fecha_inicio') is-invalid @enderror" placeholder="Selecciona una fecha"
                readonly value="{{ old('fecha_inicio') }}">
            <div id="picker-siembra" class="mt-2"></div>
            @error('fecha_inicio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="fecha_cosecha">Fecha de Cosecha</label>
            <input type="text" name="fecha_cosecha" id="fecha_cosecha"
                class="form-control @error('fecha_cosecha') is-invalid @enderror" placeholder="Selecciona una fecha"
                readonly value="{{ old('fecha_cosecha') }}">
            <div id="picker-cosecha" class="mt-2"></div>
            @error('fecha_cosecha')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="border border-secondary rounded p-2" style="width: 100%; height: 175px; background-color: #f0f0f0;">
        <canvas id="graficaProduccion" style="height: 100%; width: 100%;"></canvas>
    </div>
</div>
