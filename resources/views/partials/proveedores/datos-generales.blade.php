{{-- =========================================
     COLUMNA IZQUIERDA (Datos Generales)
========================================= --}}
<div class="col-md-6 pl-0">
    <h3 class="font-weight-bold titulo-datos" style="font-size: 3.5rem;">Datos Generales</h3>

    {{-- BLOQUE 1: FOTO + CAMPOS GENERALES --}}
    <div class="row mb-4">
        {{-- Foto --}}
        <div class="col-6 d-flex justify-content-center">
            <div class="border border-secondary rounded"
                style="width: 100%; padding-top: 100%; position: relative; background-color: #f0f0f0;">
                <span
                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
                             color: #888; font-size: 0.9rem;">
                    Foto
                </span>
            </div>
        </div>

        {{-- Inputs generales --}}
        <div class="col-6">
            <div class="form-group mb-1">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre"
                    class="form-control @error('nombre') is-invalid @enderror" placeholder="Ingresa tu nombre"
                    value="{{ old('nombre') }}">
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-1">
                <label for="edad">Edad</label>
                <input type="number" name="edad" id="edad"
                    class="form-control @error('edad') is-invalid @enderror" placeholder="Ingresa tu edad"
                    value="{{ old('edad') }}">
                @error('edad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-1">
                <label for="nacionalidad">Nacionalidad</label>
                <input type="text" name="nacionalidad" id="nacionalidad"
                    class="form-control @error('nacionalidad') is-invalid @enderror"
                    placeholder="Ingresa tu nacionalidad" value="{{ old('nacionalidad') }}">
                @error('nacionalidad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-1">
                <label for="curp">CURP</label>
                <input type="text" name="curp" id="curp"
                    class="form-control @error('curp') is-invalid @enderror" placeholder="Ingresa tu CURP"
                    value="{{ old('curp') }}">
                @error('curp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-1">
                <label for="rfc">RFC</label>
                <input type="text" name="rfc" id="rfc"
                    class="form-control @error('rfc') is-invalid @enderror" placeholder="Ingresa tu RFC"
                    value="{{ old('rfc') }}">
                @error('rfc')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- BLOQUE 2: MAPA + CAMPOS PRODUCTIVOS --}}
    <div class="row mb-0 align-items-center">
        {{-- Mapa real con Leaflet (columna izquierda) --}}
        <div class="col-6 d-flex justify-content-center">
            <div id="map" class="border border-secondary rounded"
                style="width: 100%; padding-top: 100%; position: relative; overflow: hidden;">
                {{-- El mapa ocupará 100% de este espacio con posición absoluta --}}
                <div id="map-inner" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
            </div>
        </div>

        {{-- Inputs productivos (columna derecha) --}}
        <div class="col-6">
            <div class="form-group mb-1">
                <label for="ubicacion">Ubicación (dirección)</label>
                <input type="text" name="ubicacion" id="ubicacion"
                    class="form-control @error('ubicacion') is-invalid @enderror" placeholder="Ingresa tu dirección"
                    value="{{ old('ubicacion') }}">
                @error('ubicacion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-1">
                <label for="superficie_cosecha">Superficie de cosecha (ha)</label>
                <input type="number" step="0.01" name="superficie_cosecha" id="superficie_cosecha"
                    class="form-control @error('superficie_cosecha') is-invalid @enderror"
                    placeholder="Ingresa la superficie (ha)" value="{{ old('superficie_cosecha') }}">
                @error('superficie_cosecha')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="tipo_suelo">Tipo de suelo</label>
                <input type="text" name="tipo_suelo" id="tipo_suelo"
                    class="form-control @error('tipo_suelo') is-invalid @enderror"
                    placeholder="Ingresa el tipo de suelo" value="{{ old('tipo_suelo') }}">
                @error('tipo_suelo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

</div>
