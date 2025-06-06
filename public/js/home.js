document.addEventListener('DOMContentLoaded', () => {
  const lightbox    = document.getElementById('videoLightbox');
  const backdrop    = document.querySelector('#videoLightbox .video-backdrop');
  const closeButton = document.getElementById('closeVideo');
  const iframe      = document.getElementById('lightboxIframe');

  /**
   * Extrae el ID de YouTube de una URL o devuelve
   * directamente la cadena si ya es un ID.
   */
  function extractYouTubeId(input) {
    console.log('Raw input al extractor:', input);
    // 1) Intentamos URI parsing
    try {
      const url = new URL(input);
      // youtu.be/ID
      if (url.hostname.includes('youtu.be')) {
        const id = url.pathname.slice(1);
        console.log('ID extraído (short link):', id);
        return id;
      }
      // youtube.com/watch?v=ID
      if (url.searchParams.has('v')) {
        const id = url.searchParams.get('v');
        console.log('ID extraído (?v=):', id);
        return id;
      }
    } catch (e) {
      // no era una URL válida
      console.log('No era URL válida, tratamos como ID puro');
    }
    // 2) Caída a regex genérico (cubre otros formatos)
    const regex = /(?:youtube\.com\/.*v=|youtu\.be\/)([^&?]+)/;
    const match = input.match(regex);
    if (match && match[1]) {
      console.log('ID extraído (regex):', match[1]);
      return match[1];
    }
    // 3) Si nada, devolvemos lo que nos dieron
    console.log('Devolvemos input tal cual:', input);
    return input;
  }

  function openVideo(rawId) {
    const id  = extractYouTubeId(rawId.trim());
    const src = `https://www.youtube.com/embed/${id}?autoplay=1&rel=0`;
    console.log('Iframe SRC final:', src);
    iframe.src = src;
    lightbox.classList.add('active');
  }

  function closeVideo() {
    iframe.src = '';
    lightbox.classList.remove('active');
  }

  // Asociar clic a todas las tarjetas con data-video-id
  document.querySelectorAll('[data-video-id]').forEach(card => {
    card.addEventListener('click', () => {
      const raw = card.dataset.videoId;
      console.log('Tarjeta clicada, data-video-id =', raw);
      openVideo(raw);
    });
  });

  // Cierra al hacer clic en el fondo o en la “X”
  backdrop   && backdrop.addEventListener('click', closeVideo);
  closeButton && closeButton.addEventListener('click', closeVideo);
});
