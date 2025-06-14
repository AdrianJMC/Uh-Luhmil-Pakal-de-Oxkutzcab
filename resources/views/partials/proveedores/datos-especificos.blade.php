{{-- =========================================
     COLUMNA DERECHA (Datos Específicos)
========================================= --}}
<div class="col-md-6" id="bloque-especificos">
    <h3 class="font-weight-bold titulo-datos mb-2" style="font-size: 3.5rem;">Datos Específicos</h3>

    <div class="row">
        <div class="form-group col-md-6 mb-0">
            <label for="num_trabajadores">Número de Trabajadores</label>
            <input type="number" name="num_trabajadores" id="num_trabajadores" class="form-control"
                placeholder="Ingresa la cantidad">
        </div>

        <div class="form-group col-md-6 mb-0">
            <label for="tipo_maquinaria">Tipo de maquinaria usada</label>
            <input type="text" name="tipo_maquinaria" id="tipo_maquinaria" class="form-control"
                placeholder="Ej. Tractores, aspersores...">
        </div>

        <div class="form-group col-md-6 mb-0">
            <label for="horas_trabajo">Horas trabajo semanal</label>
            <input type="number" name="horas_trabajo" id="horas_trabajo" class="form-control" placeholder="Ej. 40">
        </div>

        <div class="form-group col-md-6 mb-0">
            <label for="certificaciones">Certificaciones</label>
            <input type="text" name="certificaciones" id="certificaciones" class="form-control"
                placeholder="Ej. Orgánico, Global GAP...">
        </div>
    </div>

    <div class="row mb-0 grupo-calendarios">
        <div class="form-group col-md-6">
            <label for="fecha_inicio">Fecha de Siembra</label>
            <input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control"
                placeholder="Selecciona una fecha" readonly>
            <div id="picker-siembra" class="mt-2"></div>
        </div>

        <div class="form-group col-md-6">
            <label for="fecha_cosecha">Fecha de Cosecha</label>
            <input type="text" name="fecha_cosecha" id="fecha_cosecha" class="form-control"
                placeholder="Selecciona una fecha" readonly>
            <div id="picker-cosecha" class="mt-2"></div>
        </div>
    </div>

    <div class="border border-secondary rounded p-2" style="width: 100%; height: 175px; background-color: #f0f0f0;">
        <canvas id="graficaProduccion" style="height: 100%; width: 100%;"></canvas>
    </div>
</div>


