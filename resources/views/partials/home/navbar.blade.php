@php
    $usuario = Auth::user();
    $agrupacion = Auth::guard('agrupacion')->user();
@endphp

<header class="section page-header">
    <!-- RD Navbar-->
    <div class="rd-navbar-wrap rd-navbar-modern-wrap">
        <nav class="rd-navbar rd-navbar-modern" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed"
            data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static"
            data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static"
            data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static"
            data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px"
            data-xxl-stick-up-offset="70px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-main-outer">
                <div class="rd-navbar-main">
                    <!-- RD Navbar Panel-->
                    <div class="rd-navbar-panel">
                        <!-- RD Navbar Toggle-->
                        <button class="rd-navbar-toggle"
                            data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                        <!-- RD Navbar Brand -->
                        <div class="rd-navbar-brand navbar-brand-custom d-flex align-items-center ms-0">
                            <a class="brand d-flex align-items-center" href="{{ url('/') }}">
                                @include('partials.home.logo')
                                <span class="navbar-brand-text">Uh Luhmil Pakal</span>
                            </a>
                        </div>
                    </div>
                    <div class="rd-navbar-main-element">
                        <div class="rd-navbar-nav-wrap">
                            <!-- RD Navbar Basket-->
                            <!-- Reemplaza esta sección en tu header -->
                            <div class="rd-navbar-basket-wrap">
                                {{-- Desktop --}}
                                <a href="{{ route('carrito') }}"
                                    class="rd-navbar-basket fl-bigmug-line-shopping198 {{ request()->routeIs('carrito') ? 'active' : '' }}">
                                    <span id="cart-counter">{{ $cartCount ?? 0 }}</span>
                                </a>
                            </div>

                            {{-- Carrito en móvil, visible arriba del buscador --}}
                            <div class="rd-navbar-basket-mobile-container d-block d-md-none mb-2 text-end text-center">
                                <a href="{{ route('carrito') }}"
                                    class="rd-navbar-basket fl-bigmug-line-shopping198 {{ request()->routeIs('carrito') ? 'active' : '' }}"
                                    style="font-size: 24px; position: relative;">
                                    <span id="cart-counter"
                                        style="position: absolute; top: -8px; right: -8px; background-color: #eda407; color: #fff; font-size: 12px; border-radius: 50%; padding: 2px 6px;">
                                        {{ $cartCount ?? 0 }}
                                    </span>
                                </a>
                            </div>

                            <!-- RD Navbar Search-->
                            <div class="rd-navbar-search d-none d-md-block mt-2">
                                <button class="rd-navbar-search-toggle"
                                    data-rd-navbar-toggle=".rd-navbar-search"><span></span></button>
                                <form class="rd-search" action="#">
                                    <div class="form-wrap">
                                        <label class="form-label" for="rd-navbar-search-form-input">Search...</label>
                                        <input class="rd-navbar-search-form-input form-input"
                                            id="rd-navbar-search-form-input" type="text" name="search">
                                        <button class="rd-search-form-submit fl-bigmug-line-search74"
                                            type="submit"></button>
                                    </div>
                                </form>
                            </div>
                            <!-- RD Navbar Nav-->
                            <ul class="rd-navbar-nav">
                                <li class="rd-nav-item {{ request()->routeIs('inicio') ? 'active' : '' }}">
                                    <a class="rd-nav-link" href="{{ route('inicio') }}">Inicio</a>
                                </li>
                                <li class="rd-nav-item {{ request()->routeIs('quienes-somos') ? 'active' : '' }}">
                                    <a class="rd-nav-link" href="{{ route('quienes-somos') }}">Quiénes somos</a>
                                </li>
                                <li
                                    class="rd-nav-item {{ request()->routeIs('agrupaciones.public.index') ? 'active' : '' }}">
                                    <a class="rd-nav-link"
                                        href="{{ route('agrupaciones.public.index') }}">Agrupaciones</a>
                                </li>
                                <li class="rd-nav-item {{ request()->routeIs('catalogo') ? 'active' : '' }}">
                                    <a class="rd-nav-link" href="{{ route('catalogo') }}">Catálogo</a>
                                </li>

                                @if ($agrupacion)
                                    {{-- Agrupación logueada --}}
                                    <li class="rd-nav-item dropdown d-none d-md-block d-flex align-items-center">
                                        <a href="#"
                                            class="btn btn-success rounded-pill px-3 py-2 dropdown-toggle d-flex align-items-center gap-2"
                                            id="agrupacionDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="margin-left: 1rem; transform: translateY(15px);">
                                            <i class="fa fa-leaf mr-2"></i>
                                            <span>{{ $agrupacion->nombre_agrupacion }}</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="agrupacionDropdown">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form-agrupacion').submit();">
                                                    Cerrar sesión
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    {{-- Logout para agrupaciones --}}
                                    <form id="logout-form-agrupacion" action="{{ route('logout.agrupacion') }}"
                                        method="POST" class="d-none">
                                        @csrf
                                    </form>
                                @elseif ($usuario && $usuario->roles->isNotEmpty())
                                    {{-- Usuario con al menos un rol asignado --}}
                                    <li class="rd-nav-item dropdown d-none d-md-block d-flex align-items-center">
                                        <a href="#"
                                            class="btn btn-success rounded-pill px-3 py-2 dropdown-toggle d-flex align-items-center gap-2"
                                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="margin-left: 1rem; transform: translateY(15px);">
                                            <i class="fa fa-user mr-2"></i>
                                            <span>{{ $usuario->name }} {{ $usuario->apellido }}</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                            <li class="mb-3">
                                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                                    Ir al Administrador
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form-user').submit();">
                                                    Cerrar sesión
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <form id="logout-form-user" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                @elseif ($usuario)
                                    {{-- Usuario normal logueado --}}
                                    <li class="rd-nav-item dropdown d-none d-md-block d-flex align-items-center">
                                        <a href="#"
                                            class="btn btn-success rounded-pill px-3 py-2 dropdown-toggle d-flex align-items-center gap-2"
                                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="margin-left: 1rem; transform: translateY(15px);">
                                            <i class="fa fa-user mr-2"></i>
                                            <span>{{ $usuario->name }} {{ $usuario->apellido }}</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form-user').submit();">
                                                    Cerrar sesión
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <form id="logout-form-user" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                @else
                                    {{-- Invitado --}}
                                    <li class="rd-nav-item d-none d-md-block">
                                        <a href="{{ route('seleccion.login') }}"
                                            class="btn btn-primary rounded-pill px-3 py-2 btn-login-desktop">
                                            Iniciar Sesión
                                        </a>
                                    </li>
                                    <li class="rd-nav-item d-block d-md-none">
                                        <a href="{{ route('seleccion.login') }}" class="rd-nav-link login-nav-link">
                                            Iniciar Sesión
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
