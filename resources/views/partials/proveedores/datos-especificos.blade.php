{{-- =========================================
     COLUMNA DERECHA (Datos Específicos)
========================================= --}}
<div id="seccion-especificos" class="col-md-6 d-none d-md-block">
    <h3 class="font-weight-bold titulo-datos mb-2">Datos Específicos</h3>

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


        <div class="form-group col-md-6">
            <label for="tipo_maquinaria">Tipo de maquinaria usada</label>

            <div class="dropdown">
                <button class="form-control text-left dropdown-toggle" type="button" id="dropdownMaquinaria"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Selecciona tipo de maquinaria
                </button>
                <div class="dropdown-menu p-3" aria-labelledby="dropdownMaquinaria"
                    style="max-height: 250px; overflow-y: auto;">
                    @php
                        $opcionesMaquinaria = [
                            'Tractores',
                            'Sembradoras',
                            'Cosechadoras',
                            'Arados',
                            'Rastras',
                            'Subsoladores',
                            'Cultivadoras',
                            'Rodillos agrícolas',
                            'Surcadoras',
                            'Empacadoras',
                            'Fumigadoras',
                            'Aspersores',
                            'Pulverizadoras',
                            'Sistemas de riego por goteo',
                            'Sistemas de riego por aspersión',
                            'Mangueras de riego',
                            'Motores de riego',
                            'Tanques de riego',
                            'Camiones',
                            'Remolques agrícolas',
                            'Motocultores',
                            'Desbrozadoras',
                            'Trituradoras de ramas',
                            'Plataformas de recolección',
                            'Elevadores hidráulicos',
                            'Sistemas de fertilización',
                            'Equipos de labranza mínima',
                            'Túneles o invernaderos móviles',
                        ];
                        $seleccionadas = old('tipo_maquinaria', []);
                    @endphp

                    @foreach ($opcionesMaquinaria as $maquinaria)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tipo_maquinaria[]"
                                value="{{ $maquinaria }}" id="chk_{{ Str::slug($maquinaria, '_') }}"
                                {{ in_array($maquinaria, $seleccionadas) ? 'checked' : '' }}>
                            <label class="form-check-label" for="chk_{{ Str::slug($maquinaria, '_') }}">
                                {{ $maquinaria }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            @error('tipo_maquinaria')
                <div class="invalid-feedback d-block">{{ $message }}</div>
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

    </div>

    <div class="calendario-box row mb-0 grupo-calendarios">
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

    {{-- Botones "Regresar" y "Registrar" solo en móvil --}}
    <div class="d-block d-md-none text-center mt-4">
        <button type="button" class="btn btn-outline-secondary btn-registro mr-2" id="btn-regresar">Regresar</button>
        <button type="submit" class="btn btn-primary btn-registro ml-2">Registrar</button>
    </div>
</div>
