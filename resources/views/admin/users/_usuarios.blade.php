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
        <ul class="list-group position-absolute w-100 mt-1 shadow" id="sugerencias" style="z-index: 99; display: none;">
        </ul>
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
                            <td class="align-middle text-center">
                                <button type="button" class="btn btn-outline-secondary btn-sm role-selector-toggle"
                                    data-user-id="{{ $u->id }}"
                                    data-action="{{ route('admin.users.roles', $u) }}"
                                    data-roles='@json($u->getRoleNames())'>
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                            </td>
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
<div id="roleDropdownContainer" class="d-none"
     style="position: absolute; z-index: 9999; background: white; border: 1px solid #ccc; padding: 10px; border-radius: 5px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <form method="POST" id="dynamicRoleForm">
        @csrf
        <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>Selecciona roles</strong>
            <button type="button" class="btn btn-sm btn-danger" onclick="closeDropdown()">×</button>
        </div>
        <div class="mb-2">
            @foreach ($roles as $role)
                <div class="form-check">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="form-check-input" id="role_{{ $role->id }}">
                    <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                </div>
            @endforeach
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-warning btn-sm">Guardar</button>
        </div>
    </form>
</div>

