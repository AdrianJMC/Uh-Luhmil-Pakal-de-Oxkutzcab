{{-- TÍTULO --}}
<h2 class="gestion-title m-0 mb-3">Perfiles registrados</h2>

{{-- ALERTA --}}
@if (session('success'))
    <div class="gestion-alert-success mb-3">
        {{ session('success') }}
    </div>
@endif

{{-- CONTENEDOR COMPLETO --}}
<div class="gestion-card p-0">
    <div class="table-responsive">
        <table class="table gestion-usuarios-table mb-0">
            <thead>
                <tr>
                    <th>Perfil</th>
                    <th>Descripción</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $rol)
                    <tr>
                        <td class="align-middle text-capitalize">{{ $rol->name }}</td>
                        <td class="align-middle">{{ $rol->description ?? '---' }}</td>
                        <td class="align-middle text-center">
                            @can('editar_perfiles')
                            <button type="button" class="btn-editar-verde btn btn-sm"
                                onclick="window.location.href='{{ route('admin.roles.edit', $rol) }}'">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            @endcan

                            @can('eliminar_perfiles')
                            <button class="btn btn-danger btn-sm"
                                onclick="confirmarEliminacionPerfil('{{ route('admin.roles.destroy', $rol) }}')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No hay perfiles registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
{{-- PAGINACIÓN --}}
<div class="mt-4 d-flex justify-content-center">
    {{ $roles->appends(request()->except('roles_page'))->fragment('perfiles')->links('pagination::bootstrap-4') }}
</div>

{{-- BOTÓN FLOTANTE --}}
@can('crear_perfiles')
<a href="{{ route('admin.roles.create') }}"
    class="btn btn-success rounded-circle position-fixed d-flex align-items-center justify-content-center"
    style="bottom: 20px; right: 20px; width: 50px; height: 50px; font-size: 28px; z-index: 1000;" id="btn-crear-perfil">
    +
</a>
@endcan

@include('admin.users.modals.eliminar-perfil')
