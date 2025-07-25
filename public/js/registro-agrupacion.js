// Inicializa el calendario de selección de fecha para "fecha de siembra"
flatpickr("#picker-siembra", {
    inline: true,
    dateFormat: "Y-m-d",
    onChange: function(selectedDates, dateStr) {
        document.getElementById("fecha_inicio").value = dateStr;
        document.getElementById("fecha_inicio").dispatchEvent(new Event('change'));
    }
});

// Inicializa el calendario de selección de fecha para "fecha de cosecha"
flatpickr("#picker-cosecha", {
    inline: true,
    dateFormat: "Y-m-d",
    onChange: function(selectedDates, dateStr) {
        document.getElementById("fecha_cosecha").value = dateStr;
        document.getElementById("fecha_cosecha").dispatchEvent(new Event('change'));
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById('direccion_agrupacion');
    const map = L.map('map').setView([20.97, -89.62], 13); // Vista inicial: Mérida

    // Cargar tiles de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
        maxZoom: 18,
    }).addTo(map);

    let marker = L.marker([20.97, -89.62]).addTo(map); // Agrega marcador inicial

    // Detectar ubicación actual del navegador
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            const { latitude, longitude } = pos.coords;
            map.setView([latitude, longitude], 15);
            marker.setLatLng([latitude, longitude]);

            // Obtener dirección textual con Nominatim
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
                .then(res => res.json())
                .then(data => {
                    input.value = data.display_name || `${latitude}, ${longitude}`;
                });
        });
    }

    // Si el usuario da clic en el mapa, actualizar dirección y marcador
    map.on('click', function (e) {
        const { lat, lng } = e.latlng;
        marker.setLatLng([lat, lng]);

        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
            .then(res => res.json())
            .then(data => {
                input.value = data.display_name || `${lat}, ${lng}`;
            });
    });

    // Si escribe manualmente en el input de dirección, actualizar el mapa
    input.addEventListener('change', function () {
        const query = encodeURIComponent(input.value);
        fetch(`https://nominatim.openstreetmap.org/search?q=${query}&format=json&limit=1`)
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    const { lat, lon } = data[0];
                    map.setView([lat, lon], 15);
                    marker.setLatLng([lat, lon]);
                }
            });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const siembraInput = document.getElementById("fecha_inicio");
    const cosechaInput = document.getElementById("fecha_cosecha");

    // Genera fechas y porcentajes de avance entre fechaInicio y fechaFin
    function generarDatos(fechaInicio, fechaFin) {
        const fechas = [];
        const progreso = [];

        const inicio = new Date(fechaInicio);
        const fin = new Date(fechaFin);
        const dias = Math.ceil((fin - inicio) / (1000 * 60 * 60 * 24));

        if (dias <= 0 || isNaN(dias)) return null;

        for (let i = 0; i <= dias; i += 7) {
            const fecha = new Date(inicio.getTime() + i * 24 * 60 * 60 * 1000);
            fechas.push(fecha.toLocaleDateString('es-MX', { day: '2-digit', month: 'short' }));
            progreso.push(Math.round((i / dias) * 100));
        }

        return { fechas, progreso };
    }

    // Redibuja la gráfica cada vez que cambian las fechas
    function actualizarGrafica() {
        const fechaInicio = siembraInput.value;
        const fechaFin = cosechaInput.value;
        const datos = generarDatos(fechaInicio, fechaFin);
        if (!datos) return;

        if (window.miGrafica) {
            window.miGrafica.destroy();
        }

        const ctx = document.getElementById("graficaProduccion").getContext("2d");
        window.miGrafica = new Chart(ctx, {
            type: "line",
            data: {
                labels: datos.fechas,
                datasets: [{
                    label: "Progreso estimado (%)",
                    data: datos.progreso,
                    borderColor: "#4F46E5",
                    backgroundColor: "rgba(79,70,229,0.1)",
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: value => value + "%"
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    siembraInput.addEventListener("change", actualizarGrafica);
    cosechaInput.addEventListener("change", actualizarGrafica);
});

// Si hay sesión 'success', se oculta el modal luego de 10 segundos
document.addEventListener("DOMContentLoaded", function () {
    // Mostrar modal si existe un elemento con ID y session indica éxito
    const modal = document.getElementById('modalRegistroExitoso');
    if (modal) {
        $('#modalRegistroExitoso').modal('show');

        setTimeout(() => {
            $('#modalRegistroExitoso').modal('hide');
        }, 5000); // Ocultar tras 10 segundos
    }
});
