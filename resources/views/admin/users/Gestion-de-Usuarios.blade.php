@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h2 class="gestion-title m-0">Gestión de Usuarios</h2>

            <form method="GET" class="position-relative" style="max-width: 400px; width: 100%;">
                <div class="input-group">
                    <input type="text" name="buscar" id="buscarInput" value="{{ request('buscar') }}" class="form-control"
                        placeholder="Buscar por ID, nombre, apellido o email" autocomplete="off"
                        oninput="mostrarSugerencias(this.value)">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">Buscar</button>
                    </div>
                </div>
                <ul class="list-group position-absolute w-100 mt-1 shadow" id="sugerencias"
                    style="z-index: 99; display: none;"></ul>
            </form>
        </div>

        @if (session('success'))
            <div class="gestion-alert-success">{{ session('success') }}</div>
        @endif

        <div class="card gestion-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table gestion-usuarios-table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre completo</th>
                                <th>Email</th>
                                <th class="text-center">Roles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $filtro = request('buscar');
                                $usuariosFiltrados = $users->filter(function ($user) use ($filtro) {
                                    return !$filtro ||
                                        str_contains(strtolower($user->id), strtolower($filtro)) ||
                                        str_contains(strtolower($user->name), strtolower($filtro)) ||
                                        str_contains(strtolower($user->apellido), strtolower($filtro)) ||
                                        str_contains(strtolower($user->email), strtolower($filtro));
                                });
                            @endphp

                            @forelse($usuariosFiltrados as $u)
                                <tr>
                                    <td class="align-middle">{{ $u->id }}</td>
                                    <td class="align-middle">{{ $u->name }} {{ $u->apellido }}</td>
                                    <td class="align-middle">{{ $u->email }}</td>
                                    <form action="{{ route('admin.users.roles', $u) }}" method="POST">
                                        @csrf
                                        <td class="align-middle text-center">
                                            <div class="role-selector">
                                                <button type="button" class="role-selector-toggle"
                                                    data-user-id="{{ $u->id }}">
                                                    Seleccionar
                                                </button>
                                                @foreach ($roles as $role)
                                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                        {{ $u->hasRole($role->name) ? 'checked' : '' }} hidden>
                                                @endforeach
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">No se encontraron usuarios.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Menú flotante de roles --}}
        <div id="roleDropdownContainer" class="role-dropdown-global d-none">
            <form method="POST" id="dynamicRoleForm">
                @csrf
                <div class="role-dropdown-header d-flex justify-content-between align-items-center mb-2">
                    <strong>Selecciona roles</strong>
                    <button type="button" class="btn-close-role" onclick="closeDropdown()">×</button>
                </div>
                <div class="role-dropdown-content">
                    @foreach ($roles as $role)
                        <label>
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}">
                            {{ $role->name }}
                        </label>
                    @endforeach
                </div>
                <div class="text-end mt-2">
                    <button type="submit" class="btn gestion-btn btn-sm">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const sugerencias = document.getElementById('sugerencias');
        const inputBuscar = document.getElementById('buscarInput');
        const usuarios = @json($usuariosData);

        function mostrarSugerencias(valor) {
            sugerencias.innerHTML = '';
            if (valor.trim() === '') {
                // Si está vacío, mostrar todos los usuarios como sugerencia
                usuarios.slice(0, 5).forEach(user => {
                    const item = document.createElement('li');
                    item.className = 'list-group-item list-group-item-action';
                    item.textContent = `${user.id} - ${user.nombre} ${user.apellido} (${user.email})`;
                    item.onclick = () => {
                        inputBuscar.value = user.id;
                        sugerencias.innerHTML = '';
                        sugerencias.style.display = 'none';
                        inputBuscar.closest('form').submit(); // ← fuerza el submit
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
            ).slice(0, 5); // max 5 sugerencias

            matches.forEach(user => {
                const item = document.createElement('li');
                item.className = 'list-group-item list-group-item-action';
                item.textContent = `${user.id} - ${user.nombre} ${user.apellido} (${user.email})`;
                item.onclick = () => {
                    inputBuscar.value = user.id;
                    sugerencias.innerHTML = '';
                    sugerencias.style.display = 'none';
                    inputBuscar.closest('form').submit(); // ✅ FORZAR SUBMIT AQUÍ TAMBIÉN
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

        // Dropdown flotante de roles
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.getElementById('roleDropdownContainer');
            const form = document.getElementById('dynamicRoleForm');

            window.closeDropdown = function() {
                dropdown.classList.add('d-none');
            }

            document.querySelectorAll('.role-selector-toggle').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const row = this.closest('tr');
                    const rect = this.getBoundingClientRect();
                    dropdown.style.top = (window.scrollY + rect.bottom + 5) + 'px';
                    dropdown.style.left = (window.scrollX + rect.left) + 'px';

                    const srcChecks = row.querySelectorAll(
                        'input[type="checkbox"][name="roles[]"]');
                    const dropdownChecks = dropdown.querySelectorAll(
                        'input[type="checkbox"][name="roles[]"]');

                    dropdownChecks.forEach(dc => dc.checked = false);
                    srcChecks.forEach(src => {
                        dropdownChecks.forEach(dst => {
                            if (src.value === dst.value && src.checked) {
                                dst.checked = true;
                            }
                        });
                    });

                    form.action = row.querySelector('form').action;
                    dropdown.classList.remove('d-none');
                });
            });

            document.addEventListener('click', () => {
                dropdown.classList.add('d-none');
            });

            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
@endsection
