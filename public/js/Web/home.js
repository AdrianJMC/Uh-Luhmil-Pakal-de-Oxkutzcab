document.addEventListener("DOMContentLoaded", () => {
  const lightbox = document.getElementById("videoLightbox");
  const backdrop = document.querySelector("#videoLightbox .video-backdrop");
  const closeButton = document.getElementById("closeVideo");
  const iframe = document.getElementById("lightboxIframe");

  // Devuelve SIEMPRE un URL de embed válido (YouTube/Vimeo) a partir de ID o link normal o embed ya listo
  function toEmbed(input) {
    if (!input) return null;
    const s = String(input).trim();
    let m;

    // Ya es un embed válido → úsalo tal cual
    if (/^https?:\/\/(www\.)?youtube(-nocookie)?\.com\/embed\//i.test(s)) return s;
    if (/^https?:\/\/player\.vimeo\.com\/video\//i.test(s)) return s;

    // YouTube (links normales)
    if ((m = s.match(/^https?:\/\/youtu\.be\/([A-Za-z0-9_-]{11})/i))) return `https://www.youtube-nocookie.com/embed/${m[1]}`;
    if ((m = s.match(/[?&]v=([A-Za-z0-9_-]{11})/))) return `https://www.youtube-nocookie.com/embed/${m[1]}`;
    if ((m = s.match(/\/(shorts|embed)\/([A-Za-z0-9_-]{11})/))) return `https://www.youtube-nocookie.com/embed/${m[2]}`;

    // YouTube (ID pelón)
    if (/^[A-Za-z0-9_-]{11}$/.test(s)) return `https://www.youtube-nocookie.com/embed/${s}`;

    // Vimeo
    if ((m = s.match(/vimeo\.com\/(?:video\/)?(\d+)/))) return `https://player.vimeo.com/video/${m[1]}`;
    if (/^\d{6,}$/.test(s)) return `https://player.vimeo.com/video/${s}`;

    return null;
  }

  function appendParams(url, params) {
    const qs = new URLSearchParams(params).toString();
    return url + (url.includes("?") ? "&" : "?") + qs;
  }

  function openVideo(raw) {
    const embed = toEmbed(raw);
    if (!embed) {
      console.warn("No pude reconocer el link de video:", raw);
      return;
    }
    // ⚠️ No antepongas nada: solo añade parámetros
    iframe.src = appendParams(embed, { autoplay: 1, rel: 0, playsinline: 1 });
    lightbox.classList.add("active");
  }

  function closeVideo() {
    iframe.src = "";
    lightbox.classList.remove("active");
  }

  // Acepta data-video-src o data-video-id (el que estés usando)
  document.querySelectorAll("[data-video-src], [data-video-id]").forEach((card) => {
    card.addEventListener("click", () => {
      const raw = card.dataset.videoSrc || card.dataset.videoId;
      openVideo(raw);
    });
  });

  backdrop && backdrop.addEventListener("click", closeVideo);
  closeButton && closeButton.addEventListener("click", closeVideo);
});


let modalAgrupacionesInstance = null;

function abrirModalAgrupaciones(catalogoId, catalogoNombre, url = null) {
    const modalElement = document.getElementById("modalAgrupaciones");
    const modalLabel = document.getElementById("modalAgrupacionesLabel");
    const contenido = document.getElementById("agrupacionesContent");
    const fetchUrl = url || `/catalogos/${catalogoId}/agrupaciones`;

    modalLabel.textContent = `Agrupaciones con "${catalogoNombre}"`;

    if (!modalAgrupacionesInstance) {
        modalAgrupacionesInstance = new bootstrap.Modal(modalElement, {
            keyboard: true,
            backdrop: true,
        });
    }
    modalAgrupacionesInstance.show();

    contenido.innerHTML = `
  <div class="d-flex flex-column align-items-center justify-content-center py-3" style="font-size: 0.9rem;">
    <div class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></div>
    <small class="mt-2 text-muted">Cargando agrupaciones...</small>
  </div>`;
    fetch(fetchUrl)
        .then((res) => res.json())
        .then((data) => {
            if (data.message) {
                contenido.innerHTML = `<div class="alert alert-info">${data.message}</div>`;
                return;
            }

            if (!data.data || !Array.isArray(data.data)) {
                contenido.innerHTML = `<div class="alert alert-danger">Formato de respuesta inválido.</div>`;
                return;
            }

            // Renderizar agrupaciones
            let html = '<ul class="list-group">';
            data.data.forEach((agr) => {
                html += `
          <li class="list-group-item">
            <strong>${agr.nombre_agrupacion || "Sin nombre"}</strong><br>
            <div>Representante: ${
                agr.nombre_representante || "No especificado"
            }</div>
            ${
                agr.email_representante
                    ? `<div>Email: <a href="mailto:${agr.email_representante}">${agr.email_representante}</a></div>`
                    : ""
            }
          </li>`;
            });
            html += "</ul>";

            // Renderizar paginación estilo Bootstrap
            if (data.links && data.links.length > 1) {
                html += `<div class="pagination-wrapper">`;
                data.links.forEach((link) => {
                    const isActive = link.active ? "active" : "";
                    const isDisabled = !link.url ? "disabled" : "";
                    let label = link.label
                        .replace("&laquo;", "«")
                        .replace("&raquo;", "»");
                    if (label.toLowerCase().includes("previous")) label = "«";
                    if (label.toLowerCase().includes("next")) label = "»";

                    html += `
      <button class="pagination-button ${isActive}" 
              data-url="${link.url || ""}" 
              ${isDisabled ? "disabled" : ""}>
        ${label}
      </button>`;
                });
                html += `</div>`;
            }

            contenido.innerHTML = html;

            // Reasociar eventos a enlaces de paginación
            contenido.querySelectorAll(".pagination-button").forEach((btn) => {
                btn.addEventListener("click", (e) => {
                    e.preventDefault();
                    const fullUrl = btn.getAttribute("data-url");
                    if (!fullUrl || fullUrl === "#") return;

                    const parsedUrl = new URL(fullUrl, window.location.origin);
                    const urlDestino = parsedUrl.pathname + parsedUrl.search;

                    abrirModalAgrupaciones(
                        catalogoId,
                        catalogoNombre,
                        urlDestino
                    );
                });
            });
        })
        .catch((error) => {
            console.error("Error:", error);
            contenido.innerHTML = `<div class="alert alert-danger">Error al cargar agrupaciones: ${error.message}</div>`;
        });
}

// Función para cerrar el modal
function cerrarModalAgrupaciones() {
    if (modalAgrupacionesInstance) {
        modalAgrupacionesInstance.hide();
    }
}

// Event listeners
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("modalAgrupaciones");

    // Cerrar al hacer clic en los botones
    document
        .getElementById("btnCloseModalTop")
        ?.addEventListener("click", cerrarModalAgrupaciones);
    document
        .getElementById("btnCloseModal")
        ?.addEventListener("click", cerrarModalAgrupaciones);

    // Limpiar instancia al ocultar
    modal?.addEventListener("hidden.bs.modal", function () {
        modalAgrupacionesInstance = null;
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    const cartAddRoute = document
        .querySelector('meta[name="route-cart-add"]')
        .getAttribute("content");
    const loginRoute = document
        .querySelector('meta[name="route-login"]')
        .getAttribute("content");

    document.querySelectorAll(".add-to-cart-btn").forEach((button) => {
        button.addEventListener("click", async function () {
            const productId = this.dataset.id;
            const btn = this;

            btn.disabled = true;
            btn.innerHTML =
                '<i class="fas fa-spinner fa-spin"></i> Añadiendo...';

            try {
                const response = await fetch(cartAddRoute, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    body: JSON.stringify({
                        product_id: productId,
                    }),
                });

                if (response.status === 401) {
                    window.location.href = loginRoute;
                    return;
                }

                const text = await response.text();

                let data = null;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error(
                        "⚠️ Respuesta no fue JSON. Esto llegó del servidor:\n",
                        text
                    );
                    btn.innerHTML = "Error";
                    btn.disabled = false;
                    return;
                }

                if (data && data.success) {
                    btn.innerHTML =
                        '<i class="fas fa-check-circle text-success"></i> Añadido';

                    const counter = document.getElementById("cart-counter");
                    if (counter && data.cart_count !== undefined) {
                        counter.textContent = data.cart_count;
                    }

                    setTimeout(() => {
                        btn.innerHTML = "Añadir al carrito";
                        btn.disabled = false;
                    }, 3000);
                } else {
                    btn.innerHTML = "Error";
                    btn.disabled = false;
                    console.error("Error desde backend:", data);
                }
            } catch (error) {
                console.error("Error de red o JS:", error);
                btn.innerHTML = "Error";
                btn.disabled = false;
            }
        });
    });
});
