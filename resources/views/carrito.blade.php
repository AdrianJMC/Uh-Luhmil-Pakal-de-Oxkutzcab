@php $mostrarLoader = true; @endphp

@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('content')
    <section class="section section-lg bg-default">
        <div class="container px-1">
            <div class="row">
                <div class="col-lg-8 px-1">
                    <div class="cart-header">
                        <h2>Tu Pedido</h2>
                        <p class="text-muted">Resumen de productos agregados</p>
                    </div>

                    <div class="cart-items">
                        @if (count($cart) > 0)
                            @foreach ($cart as $key => $item)
                                <div class="cart-item">
                                    {{-- Desktop layout --}}
                                    <div class="row align-items-center d-none d-md-flex">
                                        {{-- Imagen --}}
                                        <div class="col-md-2">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="product-image">
                                        </div>

                                        {{-- Nombre + Agrupación --}}
                                        <div class="col-md-3">
                                            <h5 class="product-title" title="{{ $item['name'] }}">{{ $item['name'] }}</h5>
                                            <p class="text-muted mb-1">
                                                Agrupación:
                                                <span class="agrupacion-nombre" title="{{ $item['agrupacion'] }}">
                                                    {{ $item['agrupacion'] }}
                                                </span>
                                            </p>
                                        </div>

                                        {{-- Precio por tonelada --}}
                                        <div class="col-md-2">
                                            <small class="text-muted d-block mb-1">
                                                ${{ number_format($item['price'], 2) }} por Tonelada
                                            </small>
                                        </div>

                                        {{-- Controles cantidad --}}
                                        <div class="col-md-1 d-flex flex-column align-items-center">
                                            <form action="{{ route('cart.update', $item['id']) }}" method="POST"
                                                class="update-form">
                                                @csrf
                                                <button type="button"
                                                    class="btn btn-outline-secondary btn-update-cart mb-1"
                                                    data-action="increase" data-id="{{ $key }}">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <input type="text" class="form-control text-center quantity-display mb-1"
                                                    data-quantity="{{ $item['quantity'] }}"
                                                    value="{{ fmod($item['quantity'], 1) === 0.0 ? (int) $item['quantity'] : number_format($item['quantity'], 1) }}"
                                                    readonly>
                                                <button type="button" class="btn btn-outline-secondary btn-update-cart"
                                                    data-action="decrease" data-id="{{ $key }}">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </form>
                                        </div>

                                        {{-- Total --}}
                                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                                            <h5 class="item-total mb-0">
                                                ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                            </h5>
                                        </div>

                                        {{-- Botón eliminar --}}
                                        <div class="col-md-2 d-flex align-items-center justify-content-end pe-3">
                                            <form action="{{ route('cart.remove', $key) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm btn-eliminar-carrito">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Mobile layout --}}
                                    @include('partials.carrito.layout-mobile', [
                                        'item' => $item,
                                        'key' => $key,
                                    ])
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                Tu carrito está vacío
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="cart-summary card shadow">
                        <div class="card-body">
                            <h4 class="card-title">Resumen del Pedido</h4>

                            @php
                                $subtotal = 0;
                                $totalQuantity = 0;
                                $productCount = count($cart);

                                foreach ($cart as $item) {
                                    $subtotal += $item['price'] * $item['quantity'];
                                    $totalQuantity += $item['quantity'];
                                }

                                $total = $subtotal;
                            @endphp

                            <div class="summary-item">
                                <span>{{ $productCount }} Producto(s)</span>
                                <span
                                    id="total-ton">{{ fmod($totalQuantity, 1) === 0.0 ? (int) $totalQuantity : number_format($totalQuantity, 1) }}
                                    Ton</span>

                            </div>

                            <hr>

                            <div class="summary-item total">
                                <strong>Total</strong>
                                <strong>${{ number_format($total, 2) }}</strong>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                @if (count($cart) > 0)
                                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal"
                                        data-bs-target="#confirmarPedidoModal">
                                        Realizar Pedido
                                    </button>
                                @endif

                                <a href="{{ route('agrupaciones.public.index') }}" class="btn btn-outline-primary">
                                    Seguir Comprando
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Tap bar fijo SOLO en móvil --}}
    <div id="sticky-mobile-bar" class="d-md-none">
        <div class="sticky-bar-inner">
            <span class="sticky-total">
                Total: ${{ number_format($total, 2) }}
            </span>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarPedidoModal">
                Realizar Pedido
            </button>
        </div>
    </div>

    {{-- Modal de confirmación --}}
    @include('partials.carrito.modals.confirmacion-pedido')

@endsection

@push('scripts')
    <script src="{{ asset('js/carrito-compras.js') }}"></script>
    <script src="{{ asset('js/loader.js') }}"></script>
@endpush
