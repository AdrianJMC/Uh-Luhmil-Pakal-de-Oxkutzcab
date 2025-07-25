@php $mostrarLoader = true; @endphp
@extends('layouts.app') {{-- Asegúrate de usar tu layout principal --}}

@section('title', 'Catálogo de Productos')

@section('content')
    <section class="section section-md bg-default">
        <div class="container">
            <h2 class="text-center mb-4 catalogo-titulo">Productos</h2>
            <div class="row row-30 justify-content-center">
                @if ($products->count())
                    @foreach ($products as $product)
                        <div class="col-12 col-sm-10 col-md-6 col-lg-4 d-flex justify-content-center">
                            <div class="oh-desktop">
                                <article class="product product-2 box-ordered-item responsive-product-mobile wow fadeInUp"
                                    data-wow-delay="0s">
                                    <div class="unit flex-row flex-lg-column">
                                        <div class="unit-left">
                                            <div class="product-figure">
                                                <div class="product-img-wrapper">
                                                    <img src="{{ $product->image_url }}" alt="{{ $product->nombre }}">
                                                </div>

                                                <div class="product-button desktop-button">
                                                    @auth
                                                        @if ($product->estado === 'aprobado')
                                                            <button type="button"
                                                                class="button button-md button-white button-ujarak add-to-cart-btn"
                                                                data-id="{{ $product->id }}">
                                                                Añadir al carrito
                                                            </button>
                                                        @else
                                                            <button class="button button-md button-white button-ujarak"
                                                                disabled>
                                                                No disponible
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
                                            <h6 class="product-title"><a href="#">{{ $product->nombre }}</a></h6>
                                            <div class="product-price-wrap">
                                                <div class="product-price">
                                                    ${{ number_format($product->precio, 2) }}/Tonelada
                                                </div>
                                            </div>

                                            <div class="product-button mobile-button mt-2">
                                                @auth
                                                    @if ($product->estado === 'aprobado')
                                                        <button type="button"
                                                            class="button button-md button-white button-ujarak add-to-cart-btn"
                                                            data-id="{{ $product->id }}">
                                                            Añadir al carrito
                                                        </button>
                                                    @else
                                                        <button class="button button-md button-white button-ujarak" disabled>
                                                            No disponible
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
                    {{-- Paginación afuera de la grilla --}}
                    <div class="col-12 mt-4 d-flex justify-content-center">
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <div class="col-12 text-center py-5">
                        <h4 class="text-dark">No hay productos disponibles aún.</h4>
                        <p class="text-muted">¡Vuelve pronto para ver nuestras novedades!</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
     <script src="{{ asset('js/loader.js') }}"></script>
@endpush