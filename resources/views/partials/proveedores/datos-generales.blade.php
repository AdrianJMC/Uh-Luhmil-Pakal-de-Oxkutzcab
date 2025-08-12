{{-- =========================================
     COLUMNA IZQUIERDA (Datos Generales)
========================================= --}}
<div id="seccion-generales" class="col-md-6 pl-0">
    <h3 class="font-weight-bold titulo-datos">Datos Generales</h3>

    {{-- Inputs generales centrados verticalmente --}}
    <div class="row mb-2"> {{-- Puedes ajustar la altura --}}
        <div class="col-12 col-md-10 d-flex flex-column justify-content-center mx-auto px-3">
            <div class="form-group mb-3">
                <label for="nombre_agrupacion">Nombre de la Unidad</label>
                <input type="text" name="nombre_agrupacion" id="nombre_agrupacion"
                    class="form-control validar-dato-general @error('nombre_agrupacion') is-invalid @enderror"
                    placeholder="Ingresa el nombre de la unidad" value="{{ old('nombre_agrupacion') }}">
                @error('nombre_agrupacion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="nombre_representante">Nombre del Representante</label>
                <input type="text" name="nombre_representante" id="nombre_representante"
                    class="form-control validar-dato-general @error('nombre_representante') is-invalid @enderror"
                    placeholder="Ingresa el nombre del representante" value="{{ old('nombre_representante') }}">
                @error('nombre_representante')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="email_representante">Correo electrónico del Representante</label>
                <input type="email" name="email_representante" id="email_representante"
                    class="form-control validar-dato-general @error('email_representante') is-invalid @enderror"
                    placeholder="ejemplo@correo.com" value="{{ old('email_representante') }}">
                @error('email_representante')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="curp_representante">CURP del Representante</label>
                <input type="text" name="curp_representante" id="curp_representante"
                    class="form-control validar-dato-general @error('curp_representante') is-invalid @enderror"
                    maxlength="18" minlength="18" pattern="[A-Z0-9]{18}" required placeholder="Ingresa tu CURP"
                    value="{{ old('curp_representante') }}">
                @error('curp_representante')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="rfc_agrupacion">RFC de la Unidad</label>
                <input type="text" name="rfc_agrupacion" id="rfc_agrupacion"
                    class="form-control validar-dato-general @error('rfc_agrupacion') is-invalid @enderror"
                    maxlength="12" minlength="12" pattern="[A-Z0-9]{12}" required placeholder="Ingresa tu RFC"
                    value="{{ old('rfc_agrupacion') }}">
                @error('rfc_agrupacion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>


    {{-- BLOQUE 2: MAPA + CAMPOS PRODUCTIVOS --}}
    <div class="row mb-0 align-items-center d-flex flex-column flex-md-row">
        {{-- Mapa (siempre al inicio en móvil, a la izquierda en escritorio) --}}
        <div class="col-12 col-md-6 d-flex justify-content-center mb-3 mb-md-0">
            <div id="map" class="border border-secondary rounded w-100"
                style="padding-top: 100%; position: relative; overflow: hidden;">
                <div id="map-inner" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
            </div>
        </div>

        {{-- Campos productivos --}}
        <div class="col-12 col-md-6 d-flex justify-content-center">
            <div class="w-100" style="max-width: 500px;"> {{-- centrado en móvil --}}
                <div class="form-group mb-3">
                    <label for="direccion_agrupacion">Dirección de la Unidad</label>
                    <input type="text" name="direccion_agrupacion" id="direccion_agrupacion"
                        class="form-control validar-dato-general @error('direccion_agrupacion') is-invalid @enderror"
                        placeholder="Ingresa tu dirección" value="{{ old('direccion_agrupacion') }}">
                    @error('direccion_agrupacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="superficie_cosecha">Superficie de cosecha (ha)</label>
                    <input type="number" step="0.1" min="0.1" max="50" name="superficie_cosecha"
                        id="superficie_cosecha"
                        class="form-control validar-dato-general @error('superficie_cosecha') is-invalid @enderror"
                        placeholder="Ingresa la superficie (ha)" value="{{ old('superficie_cosecha') }}">
                    @error('superficie_cosecha')
                        <div class="text-danger" style="color:#e3342f; font-size: 0.875rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="tipo_suelo">Tipo de suelo</label>
                    <input type="text" name="tipo_suelo" id="tipo_suelo"
                        class="form-control validar-dato-general @error('tipo_suelo') is-invalid @enderror"
                        placeholder="Ingresa el tipo de suelo" value="{{ old('tipo_suelo') }}">
                    @error('tipo_suelo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>


    {{-- Botón "Siguiente" solo en móvil --}}
    <div class="d-block d-md-none text-center mt-4">
        <button type="button" class="btn2 btn-primary px-4" id="btn-siguiente">Siguiente</button>
        <div id="mensaje-validacion" class="mb-2 mt-4" style="display: none; color: #e3342f; font-weight: 600;">
            <!-- Aquí aparecerá el mensaje -->
        </div>
    </div>
</div>
