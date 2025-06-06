@extends('layouts.app')

@section('title', 'Proveedores | Uh Luhmil Pakal')

@section('content')
    <div class="container-fluid py-5">
        <h2 class="text-center">Únete como Proveedor</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('proveedores.store') }}" method="POST">
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
@endsection

@push('scripts')
    <script>
        flatpickr("#picker-siembra", {
            inline: true,
            dateFormat: "Y-m-d",
            monthSelectorType: "dropdown",
            yearSelectorType: "dropdown",
            onChange: function(selectedDates, dateStr) {
                document.getElementById("fecha_inicio").value = dateStr;
            }
        });

        flatpickr("#picker-cosecha", {
            inline: true,
            dateFormat: "Y-m-d",
            monthSelectorType: "dropdown",
            yearSelectorType: "dropdown",
            onChange: function(selectedDates, dateStr) {
                document.getElementById("fecha_cosecha").value = dateStr;
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.getElementById('ubicacion');
            const map = L.map('map').setView([20.97, -89.62], 13); // Posición inicial: Mérida

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap',
                maxZoom: 18,
            }).addTo(map);

            let marker = L.marker([20.97, -89.62]).addTo(map);

            // Detectar ubicación del navegador
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(pos => {
                    const {
                        latitude,
                        longitude
                    } = pos.coords;
                    map.setView([latitude, longitude], 15);
                    marker.setLatLng([latitude, longitude]);

                    fetch(
                            `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
                        .then(res => res.json())
                        .then(data => {
                            input.value = data.display_name || `${latitude}, ${longitude}`;
                        });
                });
            }

            // Evento: clic en el mapa
            map.on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                marker.setLatLng([lat, lng]);
                fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                    .then(res => res.json())
                    .then(data => {
                        input.value = data.display_name || `${lat}, ${lng}`;
                    });
            });

            // Evento: escribir manualmente en el input
            input.addEventListener('change', function() {
                const query = encodeURIComponent(input.value);
                fetch(`https://nominatim.openstreetmap.org/search?q=${query}&format=json&limit=1`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const {
                                lat,
                                lon
                            } = data[0];
                            map.setView([lat, lon], 15);
                            marker.setLatLng([lat, lon]);
                        }
                    });
            });
        });
    </script>
@endpush
