@extends('layouts.app')

@section('title', 'Registro de Agrupación')

@section('content')
    <div class="container-fluid py-5">
        <h2 class="title-registro text-center">Registro de Unidades</h2>

        <form action="{{ route('agrupaciones.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                @include('partials.proveedores.datos-generales')
                @include('partials.proveedores.datos-especificos')
            </div>

            {{-- Botón "Registrar" SOLO escritorio --}}
            <div class="d-none d-md-block mt-4 text-center">
                <button type="submit" class="btn2 btn-primary px-5">Registrar</button>
            </div>
        </form>
    </div>

    @if (session('success'))
        @include('partials.proveedores.modal-registro-exitoso')
    @endif
@endsection

@push('scripts')
    <script>
        const oldFechaSiembra = @json(old('fecha_inicio'));
        const oldFechaCosecha = @json(old('fecha_cosecha'));
    </script>
    <script src="@assetAuto('js/Web/registro-agrupacion.js')"></script>
@endpush
