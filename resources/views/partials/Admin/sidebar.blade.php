        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            @php
                $logoPath = \App\Models\Setting::getValue('logo', 'images/logo.png');
            @endphp

            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <img src="{{ Str::startsWith($logoPath, 'http') ? $logoPath : asset($logoPath) }}" alt="Logo"
                    class="brand-image img-circle elevation-3 bg-white p-1" style="opacity: .8">
                <span class="brand-text font-weight-light">Administrador</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                @auth
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                                alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">
                                {{ auth()->user()->name }} {{ auth()->user()->apellido }}
                            </a>
                        </div>
                    </div>
                @endauth

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                        <!-- Menú común para todos -->
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        @can('ver_usuarios')
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.roles.update-permissions') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Gestión de Usuarios</p>
                                </a>
                            </li>
                        @endcan

                        <!-- Para content-editor y super-admin -->
                        @canany(['ver_logo', 'ver_pagina_inicio', 'ver_infos', 'ver_slides'])
                            <li class="nav-item">
                                <a href="{{ route('admin.pages.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.pages.*') || request()->routeIs('admin.slides.*') || request()->routeIs('admin.infos.*') || request()->routeIs('admin.settings.logo.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <p>Secciones Web</p>
                                </a>
                            </li>
                        @endcanany

                        @can('ver_agrupaciones')
                            <li class="nav-item">
                                <a href="{{ route('admin.agrupaciones.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.agrupaciones.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-seedling"></i>
                                    <p>Gestor de Agrupaciones</p>
                                </a>
                            </li>
                        @endcan

                        @can('ver_productos')
                            <li class="nav-item">
                                <a href="{{ route('admin.productos.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-carrot"></i>
                                    <p>Productos</p>
                                </a>
                            </li>
                        @endcan

                        @can('ver_catalogos')
                            <li class="nav-item">
                                <a href="{{ route('admin.catalogos.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.catalogos.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list-alt"></i>
                                    <p>Gestor de Catálogos</p>
                                </a>
                            </li>
                        @endcan

                        @can('ver_pedidos')
                            <li class="nav-item">
                                <a href="{{ route('admin.pedidos.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-receipt"></i>
                                    <p>Pedidos</p>
                                </a>
                            </li>
                        @endcan

                        <li class="nav-item">
                            <a href="#" class="nav-link text-danger"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <Strong>
                                    <p>Cerrar sesión</p>
                                </Strong>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
