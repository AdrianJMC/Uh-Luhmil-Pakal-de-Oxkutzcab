@props([
    'products' => [],
    'randomCount' => 4,
])

<section class="section section-md bg-default">
    <div class="container">
        <div class="row row-40 justify-content-center">
            <div class="col-sm-8 col-md-7 col-lg-6 wow fadeInLeft" data-wow-delay="0s">
                {{-- Banner o contenido fijo --}}
                <div class="product-banner">
                    <img src="{{ asset('images/Organic-Vegetables.avif') }}" alt="Productos orgánicos" width="570"
                        height="715">
                    <div class="product-banner-content">
                        <div class="product-banner-inner" style="background-image: url('{{ asset('images/') }}')">
                            <h3 class="text-secondary-1">Frescura</h3>
                            <h2 class="text-primary">Natural</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-lg-6">
                <div class="row row-30 justify-content-center">
                    @if (count($products) > 0)
                        @foreach ($products as $product)
                            <div class="col-12 col-sm-10 col-md-12 col-lg-6 d-flex justify-content-center">
                                <div class="oh-desktop">
                                    <article
                                        class="product product-2 box-ordered-item responsive-product-mobile wow {{ in_array($loop->index, [0, 3]) ? 'slideInRight' : 'slideInLeft' }}"
                                        data-wow-delay="0s">
                                        <div class="unit flex-row flex-lg-column">
                                            <div class="unit-left">
                                                <div class="product-figure">
                                                    <img src="{{ $product->image_url }}" alt="{{ $product->nombre }}"
                                                        width="270" height="280">

                                                    {{-- BOTÓN flotante solo visible en escritorio: debe estar dentro de product-figure --}}
                                                    <div class="product-button desktop-button">
                                                        @auth
                                                            @if ($product->estado == 'aprobado')
                                                                <button type="button"
                                                                    class="button button-md button-white button-ujarak add-to-cart-btn"
                                                                    data-id="{{ $product->id }}"
                                                                    id="add-to-cart-desktop-{{ $product->id }}">
                                                                    Añadir al carrito
                                                                </button>
                                                            @else
                                                                <button class="button button-md button-white button-ujarak"
                                                                    disabled>
                                                                    Producto no disponible
                                                                </button>
                                                            @endif
                                                        @else
                                                            <a href="{{ route('seleccion.login') }}"
                                                                class="button button-md button-white button-ujarak">
                                                                Añadir al carrito
                                                            </a>
                                                        @endauth
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="unit-body">
                                                <h6 class="product-title"><a href="#">{{ $product->nombre }}</a>
                                                </h6>
                                                <div class="product-price-wrap">
                                                    <div class="product-price">
                                                        ${{ number_format($product->precio, 2) }}/Tonelada
                                                    </div>
                                                </div>

                                                {{-- BOTÓN DE AÑADIR DEBAJO DEL PRECIO --}}
                                                {{-- BOTÓN flotante solo visible en escritorio --}}
                                                <div class="product-button mobile-button mt-2">
                                                    @auth
                                                        @if ($product->estado == 'aprobado')
                                                            <button type="button"
                                                                class="button button-md button-white button-ujarak add-to-cart-btn"
                                                                data-id="{{ $product->id }}"
                                                                id="add-to-cart-desktop-{{ $product->id }}">
                                                                Añadir al carrito
                                                            </button>
                                                        @else
                                                            <button class="button button-md button-white button-ujarak"
                                                                disabled>
                                                                Producto no disponible
                                                            </button>
                                                        @endif
                                                    @else
                                                        <a href="{{ route('seleccion.login') }}"
                                                            class="button button-md button-white button-ujarak">
                                                            Añadir al carrito
                                                        </a>
                                                    @endauth
                                                </div>

                                            </div>

                                        </div>
                                    </article>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Mensaje cuando no hay productos --}}
                        <div class="col-12">
                            <div class="no-products-message text-center py-5 px-3">
                                <div class="icon-container mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#2f7d32"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path
                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>
                                </div>
                                <h4 class="text-dark mb-3">¡Nuestros productos están en camino!</h4>
                                <p class="text-muted mb-4">Estamos preparando los mejores productos orgánicos para ti.
                                    Regresa pronto para descubrir nuestra selección premium.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
