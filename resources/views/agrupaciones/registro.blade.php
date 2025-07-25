@extends('layouts.app')

@section('title', 'Registro de Agrupación')

@section('content')
    <div class="container-fluid py-5">
        <h2 class="text-center">Únete a la Agrupación de Productores</h2>

        <form action="{{ route('agrupaciones.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                @include('partials.proveedores.datos-generales')
                @include('partials.proveedores.datos-especificos')
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn2 btn-primary px-5">Registrar</button>
            </div>
        </form>
    </div>

    @if (session('success'))
        @include('partials.proveedores.modal-registro-exitoso')
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('js/registro-agrupacion.js') }}"></script>

    <script>
        document.getElementById('tiene_rfc').addEventListener('change', function() {
            const tieneRFC = this.value === 'si';
            document.getElementById('campo_rfc_agrupacion').classList.toggle('d-none', !tieneRFC);
            document.getElementById('campo_rfc_representante').classList.toggle('d-none', tieneRFC);
        });
    </script>
@endpush
