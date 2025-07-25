// ==========================
// 1. Buscador con sugerencias
// ==========================
const sugerencias = document.getElementById('sugerencias');
const inputBuscar = document.getElementById('buscarInput');
const usuarios = window.usuariosData || [];

function mostrarSugerencias(valor) {
    sugerencias.innerHTML = '';
    if (valor.trim() === '') {
        usuarios.slice(0, 5).forEach(user => {
            const item = document.createElement('li');
            item.className = 'list-group-item list-group-item-action';
            item.textContent = `${user.id} - ${user.nombre} ${user.apellido} (${user.email})`;
            item.onclick = () => {
                inputBuscar.value = user.id;
                sugerencias.innerHTML = '';
                sugerencias.style.display = 'none';
                inputBuscar.closest('form').submit();
            };
            sugerencias.appendChild(item);
        });
        sugerencias.style.display = 'block';
        return;
    }

    const matches = usuarios.filter(u =>
        u.id.toString().includes(valor) ||
        u.nombre.toLowerCase().includes(valor.toLowerCase()) ||
        u.apellido.toLowerCase().includes(valor.toLowerCase()) ||
        u.email.toLowerCase().includes(valor.toLowerCase())
    ).slice(0, 5);

    matches.forEach(user => {
        const item = document.createElement('li');
        item.className = 'list-group-item list-group-item-action';
        item.textContent = `${user.id} - ${user.nombre} ${user.apellido} (${user.email})`;
        item.onclick = () => {
            inputBuscar.value = user.id;
            sugerencias.innerHTML = '';
            sugerencias.style.display = 'none';
            inputBuscar.closest('form').submit();
        };
        sugerencias.appendChild(item);
    });

    sugerencias.style.display = matches.length ? 'block' : 'none';
}

document.addEventListener('click', e => {
    if (!e.target.closest('#buscarInput')) {
        sugerencias.style.display = 'none';
    }
});

// ==========================
// 2. Menú flotante de roles
// ==========================
window.addEventListener('load', () => {
    const dropdown = document.getElementById('roleDropdownContainer');
    const form = document.getElementById('dynamicRoleForm');

    window.closeDropdown = () => dropdown.classList.add('d-none');

    document.querySelectorAll('.role-selector-toggle').forEach(button => {
        button.addEventListener('click', e => {
            e.stopPropagation();

            const action = button.dataset.action;
            const roles = JSON.parse(button.dataset.roles || '[]');

            const rect = button.getBoundingClientRect();
            dropdown.style.top = `${window.scrollY + rect.bottom + 5}px`;
            dropdown.style.left = `${window.scrollX + rect.left}px`;

            dropdown.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                cb.checked = roles.includes(cb.value);
            });

            form.action = action;
            dropdown.classList.remove('d-none');
        });
    });

    document.addEventListener('click', () => dropdown.classList.add('d-none'));
    dropdown.addEventListener('click', e => e.stopPropagation());
});

// ==========================
// 3. Activar pestaña desde ?tab=
// ==========================
window.addEventListener('load', () => {
    const tabParam = new URLSearchParams(window.location.search).get('tab');
    const usuariosTab = document.querySelector('#usuarios-tab');
    const perfilesTab = document.querySelector('#perfiles-tab');
    const usuariosPane = document.querySelector('#usuarios');
    const perfilesPane = document.querySelector('#perfiles');

    usuariosTab.classList.remove('active');
    perfilesTab.classList.remove('active');
    usuariosPane.classList.remove('show', 'active');
    perfilesPane.classList.remove('show', 'active');

    if (tabParam === 'perfiles') {
        perfilesTab.classList.add('active');
        perfilesPane.classList.add('show', 'active');
    } else {
        usuariosTab.classList.add('active');
        usuariosPane.classList.add('show', 'active');
    }
});

// ==========================
// 4. Actualizar ?tab= en la URL al cambiar pestaña
// ==========================
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('#gestionUsuariosTabs .nav-link').forEach(tab => {
        tab.addEventListener('click', function () {
            const tabId = this.getAttribute('href').replace('#', '');
            const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.replaceState({}, '', url);
        });
    });
});
// ==========================
// 5. Modal de confirmación de eliminación de perfil y usuario
// ==========================
function confirmarEliminacionUsuario(actionUrl) {
    const form = document.getElementById('formEliminarUsuario');
    form.action = actionUrl;
    $('#modalEliminarUsuario').modal('show'); // jQuery + Bootstrap 4
}

function confirmarEliminacionPerfil(actionUrl) {
    const form = document.getElementById('formEliminarPerfil');
    form.action = actionUrl;
    const modal = new bootstrap.Modal(document.getElementById('eliminarPerfilModal'));
    modal.show();
}
// ======================================
// 6. Botón "Limpiar" búsqueda
// ======================================
window.limpiarBusqueda = function () {
    const input = document.getElementById('buscarInput');
    input.value = '';
    document.getElementById('sugerencias').style.display = 'none';

    const url = new URL(window.location.href);
    url.searchParams.delete('buscar');
    url.searchParams.delete('page'); // por si tenés paginación
    window.location.href = url.toString(); // redirige sin filtros
}

// ======================================
// 7. Alertas con duracion de 5 segundos para la creacion de 5 perfiles
// ======================================
document.addEventListener('DOMContentLoaded', function () {
    const alerta = document.querySelector('.gestion-alert-success');
    if (alerta) {
        setTimeout(() => {
            alerta.style.transition = 'opacity 0.5s ease';
            alerta.style.opacity = '0';
            setTimeout(() => alerta.remove(), 500); // elimina del DOM después de ocultarse
        }, 5000); // espera 5 segundos antes de ocultar
    }
});
