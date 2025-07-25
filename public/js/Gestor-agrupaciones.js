document.addEventListener('DOMContentLoaded', () => {
    // -------------------------
    // Activar pestaña por ?tab=
    // -------------------------
    const tabParam = new URLSearchParams(window.location.search).get('tab');
    const tabRegistradas = document.querySelector('#tab-registradas');
    const tabPendientes = document.querySelector('#tab-pendientes');
    const paneRegistradas = document.querySelector('#agrupaciones-registradas');
    const panePendientes = document.querySelector('#agrupaciones-pendientes');

    if (tabParam === 'pendientes') {
        tabPendientes?.classList.add('active');
        panePendientes?.classList.add('show', 'active');
        tabRegistradas?.classList.remove('active');
        paneRegistradas?.classList.remove('show', 'active');
    }

    // -------------------------
    // Actualizar la URL en tabs
    // -------------------------
    document.querySelectorAll('#tabsAgrupaciones .nav-link').forEach(tab => {
        tab.addEventListener('click', function () {
            const tabId = this.getAttribute('href').replace('#agrupaciones-', '');
            const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.replaceState({}, '', url);
        });
    });

    // -------------------------
    // Mostrar sugerencias
    // -------------------------
    window.mostrarSugerenciasAgrupacion = function (valor) {
        const query = valor.toLowerCase().trim();
        const idInput = document.activeElement.id;
        const esPendiente = idInput === 'buscarAgrupacionesPendientes';

        const input = document.getElementById(idInput);
        const lista = document.getElementById(
            esPendiente ? 'sugerenciasAgrupacionPendientes' : 'sugerenciasAgrupacionRegistradas'
        );

        const datos = esPendiente ? window.agrupacionesPendientes : window.agrupacionesRegistradas;

        const resultados = datos.filter(a =>
            a.id.toString().includes(query) ||
            a.nombre_agrupacion.toLowerCase().includes(query) ||
            a.nombre_representante.toLowerCase().includes(query) ||
            a.email_representante.toLowerCase().includes(query)
        ).slice(0, 5);

        lista.innerHTML = '';

        if (query.length === 0 || resultados.length === 0) {
            lista.style.display = 'none';
            return;
        }

        resultados.forEach(a => {
            const li = document.createElement('li');
            li.className = 'list-group-item list-group-item-action';
            li.textContent = `#${a.id} - ${a.nombre_agrupacion} (${a.nombre_representante})`;
            li.onclick = () => {
                input.value = a.nombre_agrupacion;
                lista.style.display = 'none';
            };
            lista.appendChild(li);
        });

        lista.style.display = 'block';
    };

    // Ocultar sugerencias si se hace clic fuera
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.input-group')) {
            document.getElementById('sugerenciasAgrupacionRegistradas')?.style?.setProperty('display', 'none');
            document.getElementById('sugerenciasAgrupacionPendientes')?.style?.setProperty('display', 'none');
        }
    });

    // -------------------------
    // Limpiar búsqueda
    // -------------------------
    window.limpiarBusquedaAgrupacion = function () {
        const tabParam = new URLSearchParams(window.location.search).get('tab');
        const isPendiente = tabParam === 'pendientes';
        const input = document.getElementById(isPendiente ? 'buscarAgrupacionesPendientes' : 'buscarAgrupacionesRegistradas');
        input.value = '';

        const url = new URL(window.location.href);
        url.searchParams.delete('buscar');
        window.location.href = url.toString();
    };

    // -------------------------
    // Mostrar modal de eliminar
    // -------------------------
    window.mostrarModalEliminarAgrupacion = function (id, nombre) {
        const form = document.getElementById('formEliminarAgrupacion');
        form.action = `/admin/agrupaciones/${id}`;
        document.getElementById('nombreAgrupacionAEliminar').innerText = nombre;
        $('#modalEliminarAgrupacion').modal('show');
    };
});

document.addEventListener('DOMContentLoaded', () => {
            const alerta = document.querySelector('.agrupaciones-alert-success');
            if (alerta) {
                setTimeout(() => {
                    alerta.classList.remove('show');
                    alerta.style.opacity = 0;
                    setTimeout(() => alerta.remove(), 500); // Elimina después de la transición
                }, 5000);
            }
        });
