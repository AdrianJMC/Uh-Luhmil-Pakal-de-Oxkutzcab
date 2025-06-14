@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        {{-- Navegación entre pestañas --}}
        <ul class="nav nav-tabs mb-3" id="gestionUsuariosTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link custom-tab active" id="usuarios-tab" data-toggle="tab" href="#usuarios" role="tab"
                    aria-controls="usuarios" aria-selected="true">Usuarios</a>
            </li>
            @can('gestionar_perfiles')
                <li class="nav-item">
                    <a class="nav-link custom-tab" id="perfiles-tab" data-toggle="tab" href="#perfiles" role="tab"
                        aria-controls="perfiles" aria-selected="false">Perfiles y Permisos</a>
                </li>
            @endcan
        </ul>

        <div class="tab-content" id="gestionUsuariosTabContent">
            {{-- TAB USUARIOS --}}
            <div class="tab-pane fade show active" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab">
                {{-- BUSCADOR --}}
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h2 class="gestion-title m-0">Gestión de Usuarios</h2>
                    <form method="GET" class="position-relative" style="max-width: 450px; width: 100%;">
                        <div class="input-group">
                            <input type="text" name="buscar" id="buscarInput" value="{{ request('buscar') }}"
                                class="form-control" placeholder="Buscar por ID, nombre, apellido o email"
                                autocomplete="off" oninput="mostrarSugerencias(this.value)">
                            <div class="input-group-append">
                                <button class="btn btn-warning" type="submit">Buscar</button>
                                <button class="btn btn-secondary" type="button"
                                    onclick="limpiarBusqueda()">Limpiar</button>
                            </div>
                        </div>
                        <ul class="list-group position-absolute w-100 mt-1 shadow" id="sugerencias"
                            style="z-index: 99; display: none;"></ul>
                    </form>
                </div>

                @if (session('user_success') && request('tab') === 'usuarios')
                    <div class="gestion-alert-success">{{ session('user_success') }}</div>
                @endif

                {{-- TABLA USUARIOS --}}
                <div class="card gestion-card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table gestion-usuarios-table mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre completo</th>
                                        <th>Email</th>
                                        <th class="text-center">Acciones</th>
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
                                                <div class="role-selector">
                                                    @can('editar_usuarios')
                                                        <button type="button"
                                                            class="role-selector-toggle btn btn-outline-secondary btn-sm"
                                                            data-user-id="{{ $u->id }}"
                                                            data-action="{{ route('admin.users.roles', $u) }}"
                                                            data-roles='@json($u->getRoleNames())'>
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                    @endcan
                                                    @can('editar_usuarios')
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="confirmarEliminacionUsuario('{{ route('admin.users.destroy', $u) }}')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">No se encontraron
                                                usuarios.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
           
            

            {{-- TAB PERFILES --}}
            <div class="tab-pane fade" id="perfiles" role="tabpanel" aria-labelledby="perfiles-tab">
                @include('admin.users._perfiles')
            </div>
        </div>
    </div>

    {{-- MENÚ FLOTANTE DE ROLES --}}
    <div id="roleDropdownContainer" class="role-dropdown-global d-none"
        style="position: absolute; z-index: 1000; background: white; border: 1px solid #ddd; padding: 10px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <form method="POST" id="dynamicRoleForm">
            @csrf
            <div class="role-dropdown-header d-flex justify-content-between align-items-center mb-2">
                <strong>Selecciona roles</strong>
                <button type="button" class="btn btn-sm btn-danger" onclick="closeDropdown()">×</button>
            </div>
            <div class="role-dropdown-content mb-2">
                @foreach ($roles as $role)
                    <div class="form-check">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="form-check-input"
                            id="check_{{ $role->id }}">
                        <label class="form-check-label" for="check_{{ $role->id }}">{{ $role->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-warning btn-sm">Guardar</button>
            </div>
        </form>
    </div>

    @include('admin.users.modals.eliminar-usuario')
@endsection

@push('scripts')
    <script>
        window.usuariosData = @json($usuariosData ?? []);
    </script>
    <script src="{{ asset('js/Gestion-de-usuarios.js') }}"></script>
@endpush
