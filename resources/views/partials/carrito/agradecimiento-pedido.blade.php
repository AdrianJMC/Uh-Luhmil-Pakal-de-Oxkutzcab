@extends('layouts.app')

@section('title', 'Gracias por tu compra')

{{-- Indicamos que no se muestre el footer --}}
@php($ocultarFooter = true)

@section('content')
    <div class="container mt-5 text-center">
        <div class="thank-you-container">
            <h2 class="mb-4">¡Gracias por tu compra!</h2>
            <p class="mb-4 fs-5">La agrupación se pondrá en contacto contigo pronto.</p>
            <div class="folio-container bg-light p-3 rounded mb-4 d-inline-block">
                <p class="mb-0 fs-5">Folio de tu pedido: <strong class="text-black">{{ $folio }}</strong></p>
            </div>
            <div class="mt-4">
                <a href="{{ route('carrito') }}" class="btn btn-custom">Seguir comprando</a>
            </div>
        </div>
    </div>
@endsection
