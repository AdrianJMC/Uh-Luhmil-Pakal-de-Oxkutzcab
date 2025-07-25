document.addEventListener("DOMContentLoaded", function () {
    const loader = document.getElementById("loadingOverlay");
    if (!loader) return;

    // Mostrar loader al enviar formularios
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", () => {
            loader.classList.add("active");
        });
    });

    // Mostrar loader en enlaces internos
    document
        .querySelectorAll('a[href]:not([target]):not([href^="#"])')
        .forEach((link) => {
            link.addEventListener("click", function () {
                loader.classList.add("active");
            });
        });

    // Ocultar loader al cargar completamente
    window.addEventListener("load", () => {
        setTimeout(() => {
            loader.classList.add("fade-out");
            setTimeout(() => {
                loader.style.display = "none";
            }, 400); // coincide con la duración del fade-out
        }, 1000); // espera 5 segundos antes de iniciar el fade-out
    });
});
