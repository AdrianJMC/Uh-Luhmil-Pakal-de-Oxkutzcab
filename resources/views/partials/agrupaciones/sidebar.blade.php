<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-success elevation-4">
    <!-- Brand Logo -->
    <!-- Brand Logo -->
    @php
        $logoPath = \App\Models\Setting::getValue('logo', 'images/logo.png');
    @endphp

    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ Str::startsWith($logoPath, 'http') ? $logoPath : asset($logoPath) }}" alt="Logo"
            class="brand-image img-circle elevation-3 bg-white p-1" style="opacity: 1">
        <span class="brand-text font-weight-light">Administrador</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        @auth('agrupacion')
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                        alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">
                        {{ auth('agrupacion')->user()->nombre_representante }}
                    </a>
                </div>
            </div>
        @endauth

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('agrupaciones.dashboard') }}"
                        class="nav-link {{ request()->routeIs('agrupaciones.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Productos (de prueba visual) -->
                <li class="nav-item">
                    <a href="{{ route('agrupaciones.productos.index') }}"
                        class="nav-link {{ request()->routeIs('agrupaciones.productos.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Mis Productos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('agrupaciones.pedidos.index') }}"
                        class="nav-link {{ request()->routeIs('agrupaciones.pedidos.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>Pedidos</p>
                    </a>
                </li>
                <li class="nav-item logout-sidebar-item">
                    <a href="#" class="nav-link logout-button"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <span class="logout-text">Cerrar sesión</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout.agrupacion') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new MutationObserver(() => {
            document.querySelectorAll('.logout-text').forEach(el => {
                el.style.display = document.body.classList.contains('sidebar-collapse') ?
                    'none' : 'inline';
            });
        });

        observer.observe(document.body, {
            attributes: true,
            attributeFilter: ['class']
        });
    });
</script>
