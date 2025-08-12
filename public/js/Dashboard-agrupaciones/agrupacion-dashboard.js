document.addEventListener('DOMContentLoaded', function () {
    const labelsSemana = window.labelsSemana || [];
    const valoresSemana = window.valoresSemana || [];

    const ctx = document.getElementById('ventasChart').getContext('2d');
    const ventasChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labelsSemana,
            datasets: [{
                label: 'Ventas ($ MXN)',
                data: valoresSemana,
                fill: true,
                borderColor: '#2f7d32',
                backgroundColor: 'rgba(47, 125, 50, 0.2)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 100
                    }
                }
            }
        }
    });
});
