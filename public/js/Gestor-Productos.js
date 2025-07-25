/* admin/productos.js
 * Lógica para gestión de productos en el panel (jQuery + vanilla JS).
 */

(function($) {
  $(function() {
    // 1. Modo selección múltiple
    const btnActivar   = $('#activarSeleccion');
    const btnCancelar  = $('#cancelarSeleccion');
    const acciones     = $('#accionesMultiples');
    const thCheckbox   = $('#thCheckbox');
    const selectAll    = $('#selectAll');
    let modoSeleccion  = false;

    function obtenerCheckboxes() {
      return $('input[name="productos[]"]');
    }

    function toggleAcciones(show) {
      acciones.toggleClass('d-flex', show).toggleClass('d-none', !show);
    }

    function actualizarBotones() {
      const marcados = $('input[name="productos[]"]:checked').length;
      toggleAcciones(modoSeleccion && marcados > 0);
    }

    // Estado inicial
    toggleAcciones(false);
    thCheckbox.addClass('d-none');
    $('.checkbox-col').addClass('d-none');

    // Botón activar
    btnActivar.on('click', () => {
      modoSeleccion = true;
      $('.checkbox-col, #thCheckbox').removeClass('d-none');
      btnActivar.addClass('d-none');
      btnCancelar.removeClass('d-none');
      $('.btn-icon-aprobar, .btn-icon-rechazar').addClass('d-none');
      actualizarBotones();
    });

    // Botón cancelar
    btnCancelar.on('click', () => {
      modoSeleccion = false;
      $('.checkbox-col, #thCheckbox').addClass('d-none');
      btnActivar.removeClass('d-none');
      btnCancelar.addClass('d-none');
      selectAll.prop('checked', false);
      obtenerCheckboxes().prop('checked', false);
      $('.btn-icon-aprobar, .btn-icon-rechazar').removeClass('d-none');
      toggleAcciones(false);
    });

    // Checkboxes individuales
    $(document).on('change', 'input[name="productos[]"]', actualizarBotones);

    // Select All
    selectAll.on('change', function() {
      obtenerCheckboxes().prop('checked', this.checked);
      actualizarBotones();
    });


    // 2. Modal de eliminación
    window.mostrarModalEliminarProducto = function(id, nombre) {
  // Ajusta la acción del formulario al método DELETE de Laravel
  $('#formEliminarProducto').attr('action', `/admin/productos/${id}?tab=${new URLSearchParams(window.location.search).get('tab') || 'aprobados'}`);
  // Ponemos el nombre en el modal
  $('#nombreProductoEliminar').text(nombre);
  // Mostramos el modal
  $('#modalEliminarProducto').modal('show');
};

    // 2bis. Modal de rechazo masivo: cargar los IDs seleccionados
    $('#modalRechazoMasivo').on('show.bs.modal', function () {
      const ids = $('input[name="productos[]"]:checked')
                    .map((_, cb) => cb.value)
                    .get()
                    .join(',');
      $('#productosSeleccionadosInput').val(ids);
    });


    // 3. Pestañas según ?tab= y actualizar URL
    const tabParam = new URLSearchParams(window.location.search).get('tab');
    if (tabParam === 'pendientes') {
      $('#tab-pendientes').tab('show');
    } else {
      $('#tab-aprobados').tab('show');
    }
    $('#tabsProductos .nav-link').on('click', function() {
      const paneId = $(this).attr('href').replace('#productos-', '');
      const url = new URL(window.location);
      url.searchParams.set('tab', paneId);
      window.history.replaceState({}, '', url);
    });


    // 4. Sugerencias de búsqueda
    window.mostrarSugerenciasProducto = function(valor) {
      const query    = valor.toLowerCase().trim();
      const activeId = document.activeElement.id; // buscarProductosAprobados | buscarProductosPendientes
      const listaId  = activeId === 'buscarProductosPendientes'
                       ? '#sugerenciasProductoPendientes'
                       : '#sugerenciasProductoAprobados';
      const datos    = activeId === 'buscarProductosPendientes'
                       ? window.productosPendientes
                       : window.productosAprobados;
      const lista    = $(listaId);
      lista.empty();

      if (!query) { lista.hide(); return; }

      const resultados = datos.filter(p =>
        p.nombre.toLowerCase().includes(query) ||
        p.categoria.toLowerCase().includes(query) ||
        (p.agrupacion?.toLowerCase() || '').includes(query)
      ).slice(0, 5);

      if (!resultados.length) { lista.hide(); return; }

      resultados.forEach(p => {
        $('<li>')
          .addClass('list-group-item list-group-item-action')
          .text(`#${p.id} - ${p.nombre} (${p.categoria})`)
          .on('click', () => {
            $('#' + activeId).val(p.nombre);
            lista.hide();
          })
          .appendTo(lista);
      });
      lista.show();
    };

    window.limpiarBusquedaProducto = function() {
      const url = new URL(window.location);
      url.searchParams.delete('buscar');
      window.location.href = url.toString();
    };

    // Ocultar sugerencias si clic fuera del input
    $(document).on('click', function(e) {
      if (!$(e.target).closest('.input-group').length) {
        $('#sugerenciasProductoAprobados, #sugerenciasProductoPendientes').hide();
      }
    });
  });
})(jQuery);
