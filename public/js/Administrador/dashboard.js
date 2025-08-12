document.addEventListener("DOMContentLoaded", () => {
    const { ventasPorMes, ventasPorCategoria, graficaDinamica } =
        window.datosVentas;

    // === Gráfica línea mensual ===
    const nombresMeses = [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
    ];

    const etiquetasMes = ventasPorMes.meses.map((m) => nombresMeses[m - 1]);

    const ctxMes = document
        .getElementById("revenue-chart-canvas")
        .getContext("2d");
    new Chart(ctxMes, {
        type: "line",
        data: {
            labels: etiquetasMes,
            datasets: [
                {
                    label: "Ventas por mes (MXN)",
                    data: ventasPorMes.totales,
                    borderColor: "rgba(60,141,188,1)",
                    backgroundColor: "rgba(60,141,188,0.2)",
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: "rgba(60,141,188,1)",
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: (val) => "$" + val.toLocaleString(),
                    },
                },
            },
        },
    });

    // === Donut de categorías ===
    const ctxDonut = document
        .getElementById("sales-chart-canvas")
        .getContext("2d");
    new Chart(ctxDonut, {
        type: "doughnut",
        data: {
            labels: ventasPorCategoria.categorias,
            datasets: [
                {
                    data: ventasPorCategoria.cantidades,
                    backgroundColor: [
                        "#f39c12",
                        "#00a65a",
                        "#f56954",
                        "#00c0ef",
                        "#3c8dbc",
                        "#d2d6de",
                        "#ff6384",
                        "#36a2eb",
                        "#ffcd56",
                        "#4bc0c0",
                        "#9966ff",
                        "#ff9f40",
                        "#c45850",
                        "#8e5ea2",
                        "#3cba9f",
                        "#e8c3b9",
                        "#1e7145",
                        "#b91d47",
                        "#e74c3c",
                        "#2ecc71",
                        "#3498db",
                        "#9b59b6",
                        "#1abc9c",
                        "#34495e",
                        "#16a085",
                        "#27ae60",
                        "#2980b9",
                        "#8e44ad",
                        "#f1c40f",
                        "#e67e22",
                    ],
                    borderColor: "#fff",
                    borderWidth: 2,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "right",
                    labels: { color: "#000" },
                },
            },
        },
    });

    // === Gráfica dinámica con selector ===
    const ctxLine = document.getElementById("line-chart").getContext("2d");

    let chartLine = new Chart(ctxLine, {
        type: "bar",
        data: {
            labels: graficaDinamica.productos.labels,
            datasets: [
                {
                    label: graficaDinamica.productos.label,
                    data: graficaDinamica.productos.data,
                    backgroundColor: graficaDinamica.productos.bg,
                    borderColor: graficaDinamica.productos.border,
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: { color: "white" },
                },
                tooltip: {
                    bodyColor: "white",
                    titleColor: "white",
                },
            },
            scales: {
                x: {
                    ticks: {
                        color: "white",
                        minRotation: 90,
                        maxRotation: 90,
                        font: { size: 12 },
                    },
                },
                y: {
                    beginAtZero: true,
                    ticks: { color: "white" },
                },
            },
        },
    });

    // Cambiar tipo de gráfica
    document.getElementById("tipoGrafica").addEventListener("change", (e) => {
        const tipo = e.target.value;
        const config = graficaDinamica[tipo];

        chartLine.data.labels = config.labels;
        chartLine.data.datasets[0].label = config.label;
        chartLine.data.datasets[0].data = config.data;
        chartLine.data.datasets[0].backgroundColor = config.bg;
        chartLine.data.datasets[0].borderColor = config.border;

        // Ajuste rotación solo para productos
        chartLine.options.scales.x.ticks.minRotation =
            tipo === "productos" ? 90 : 0;
        chartLine.options.scales.x.ticks.maxRotation =
            tipo === "productos" ? 90 : 0;

        chartLine.update();
    });
});
