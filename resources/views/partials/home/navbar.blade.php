    <header class="section page-header">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap rd-navbar-modern-wrap">
            <nav class="rd-navbar rd-navbar-modern" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed"
                data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static"
                data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static"
                data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static"
                data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px"
                data-xxl-stick-up-offset="70px" data-lg-stick-up="true" data-xl-stick-up="true"
                data-xxl-stick-up="true">
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
                                <div class="rd-navbar-basket-wrap">
                                    <button class="rd-navbar-basket fl-bigmug-line-shopping198"
                                        data-rd-navbar-toggle=".cart-inline"><span>2</span></button>
                                    <div class="cart-inline">
                                        <div class="cart-inline-header">
                                            <h5 class="cart-inline-title">In cart:<span> 2</span> Products</h5>
                                            <h6 class="cart-inline-title">Total price:<span> $800</span></h6>
                                        </div>
                                        <div class="cart-inline-body">
                                            <div class="cart-inline-item">
                                                <div class="unit align-items-center">
                                                    <div class="unit-left"><a class="cart-inline-figure"
                                                            href="{{ url('#') }}"><img
                                                                src="{{ asset('/images/product-mini-1-108x100.png') }}"
                                                                alt="" width="108" height="100" /></a>
                                                    </div>
                                                    <div class="unit-body">
                                                        <h6 class="cart-inline-name"><a
                                                                href="{{ url('#') }}">Blueberries</a></h6>
                                                        <div>
                                                            <div class="group-xs group-inline-middle">
                                                                <div class="table-cart-stepper">
                                                                    <input class="form-input" type="number"
                                                                        data-zeros="true" value="1" min="1"
                                                                        max="1000">
                                                                </div>
                                                                <h6 class="cart-inline-title">$550</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cart-inline-item">
                                                <div class="unit align-items-center">
                                                    <div class="unit-left"><a class="cart-inline-figure"
                                                            href="{{ url('#') }}"><img
                                                                src="{{ asset('/images/product-mini-2-108x100.png') }}"
                                                                alt="" width="108" height="100" /></a>
                                                    </div>
                                                    <div class="unit-body">
                                                        <h6 class="cart-inline-name"><a
                                                                href="{{ url('#') }}">Avocados</a></h6>
                                                        <div>
                                                            <div class="group-xs group-inline-middle">
                                                                <div class="table-cart-stepper">
                                                                    <input class="form-input" type="number"
                                                                        data-zeros="true" value="1" min="1"
                                                                        max="1000">
                                                                </div>
                                                                <h6 class="cart-inline-title">$250</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cart-inline-footer">
                                            <div class="group-sm"><a
                                                    class="button button-md button-default-outline-2 button-wapasha"
                                                    href="{{ url('#') }}">Go to cart</a><a
                                                    class="button button-md button-primary button-pipaluk"
                                                    href="{{ url('#') }}">Checkout</a></div>
                                        </div>
                                    </div>
                                </div><a class="rd-navbar-basket rd-navbar-basket-mobile fl-bigmug-line-shopping198"
                                    href="{{ url('#') }}"><span>2</span></a>
                                <!-- RD Navbar Search-->
                                <div class="rd-navbar-search">
                                    <button class="rd-navbar-search-toggle"
                                        data-rd-navbar-toggle=".rd-navbar-search"><span></span></button>
                                    <form class="rd-search" action="#">
                                        <div class="form-wrap">
                                            <label class="form-label"
                                                for="rd-navbar-search-form-input">Search...</label>
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
                                        class="rd-nav-item {{ request()->routeIs('proveedores.create') ? 'active' : '' }}">
                                        <a class="rd-nav-link" href="{{ route('proveedores.create') }}">Registro de Productores</a>
                                    </li>

                                    @guest
                                        {{-- Versión escritorio: botón estilo “btn” --}}
                                        <li class="rd-nav-item d-none d-md-block">
                                            <a href="{{ route('login') }}"
                                                class="btn btn-primary rounded-pill px-3 py-2 btn-login-desktop">
                                                Iniciar Sesión
                                            </a>
                                        </li>

                                        {{-- Versión móvil (sidebar): enlace como ítem más del menú --}}
                                        <li class="rd-nav-item d-block d-md-none">
                                            <a href="{{ route('login') }}" class="rd-nav-link login-nav-link">
                                                Iniciar Sesión
                                            </a>
                                        </li>
                                    @else
                                        <li class="rd-nav-item dropdown">
                                            <a href="#"
                                                class="btn btn-primary rounded-pill px-3 py-2 dropdown-toggle"
                                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                                style="margin-left:1rem;">
                                                <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}"
                                                    alt="Perfil" class="rounded-circle" width="24" height="24">
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                                                        Cerrar sesión
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    @endguest
                                </ul>


                            </div>
                            <div class="rd-navbar-project-hamburger" data-multitoggle=".rd-navbar-main"
                                data-multitoggle-blur=".rd-navbar-wrap" data-multitoggle-isolate>
                                <div class="project-hamburger"><span class="project-hamburger-arrow-top"></span><span
                                        class="project-hamburger-arrow-center"></span><span
                                        class="project-hamburger-arrow-bottom"></span></div>
                                <div class="project-hamburger-2"><span class="project-hamburger-arrow"></span><span
                                        class="project-hamburger-arrow"></span><span
                                        class="project-hamburger-arrow"></span>
                                </div>
                                <div class="project-close"><span></span><span></span></div>
                            </div>
                        </div>
                        <div class="rd-navbar-project rd-navbar-modern-project">
                            <div class="rd-navbar-project-modern-header">
                                <h4 class="rd-navbar-project-modern-title">Get in Touch</h4>
                                <div class="rd-navbar-project-hamburger" data-multitoggle=".rd-navbar-main"
                                    data-multitoggle-blur=".rd-navbar-wrap" data-multitoggle-isolate>
                                    <div class="project-close"><span></span><span></span></div>
                                </div>
                            </div>
                            <div class="rd-navbar-project-content rd-navbar-modern-project-content">
                                <div>
                                    <p>We are always ready to provide you with fresh organic products for your home or
                                        office. Contact us to find out how we can help you.</p>
                                    <div class="heading-6 subtitle">Our Contacts</div>
                                    <div class="row row-10 gutters-10">
                                        <div class="col-12"><img
                                                src="{{ asset('/images/home-sidebar-394x255.jpg') }}" alt=""
                                                width="394" height="255" />
                                        </div>
                                    </div>
                                    <ul class="rd-navbar-modern-contacts">
                                        <li>
                                            <div class="unit unit-spacing-sm">
                                                <div class="unit-left"><span class="icon fa fa-phone"></span></div>
                                                <div class="unit-body"><a class="link-phone"
                                                        href="{{ url('tel:#') }}">+1 323-913-4688</a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="unit unit-spacing-sm">
                                                <div class="unit-left"><span class="icon fa fa-location-arrow"></span>
                                                </div>
                                                <div class="unit-body"><a class="link-location"
                                                        href="{{ url('#') }}">4730 Crystal Springs Dr, Los
                                                        Angeles,
                                                        CA 90027</a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="unit unit-spacing-sm">
                                                <div class="unit-left"><span class="icon fa fa-envelope"></span></div>
                                                <div class="unit-body"><a class="link-email"
                                                        href="{{ url('mailto:#') }}">mail@demolink.org</a></div>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="list-inline rd-navbar-modern-list-social">
                                        <li><a class="icon fa fa-facebook" href="{{ url('#') }}"></a></li>
                                        <li><a class="icon fa fa-twitter" href="{{ url('#') }}"></a></li>
                                        <li><a class="icon fa fa-google-plus" href="{{ url('#') }}"></a></li>
                                        <li><a class="icon fa fa-instagram" href="{{ url('#') }}"></a></li>
                                        <li><a class="icon fa fa-pinterest" href="{{ url('#') }}"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
