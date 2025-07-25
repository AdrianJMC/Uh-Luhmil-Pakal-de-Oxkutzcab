{{-- resources/views/layouts/partials/footer.blade.php --}}
<footer class="section footer-variant-2 footer-modern context-dark" style="border-top: 4px solid #000000;">
    <div class="footer-variant-2-content">
        <div class="container">
            <div class="row row-40 justify-content-between">

                <!-- 1) Brand y Contactos -->
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="oh-desktop wow slideInRight" data-wow-delay="0s">
                        <div class="footer-brand mb-2 text-center">
                            <a href="{{ url('/') }}">
                                @include('partials.home.logo')
                            </a>
                        </div>
                        <p>
                            Uh Luhmil Pakal es la agrupación de productores de Oxkutzcab especializada en la siembra
                            y distribución de hortalizas y cítricos de la más alta calidad, combinando técnicas
                            ancestrales y prácticas innovadoras para llevar frescura y transparencia a cada cosecha.
                        </p>
                        <ul class="footer-contacts list-unstyled mt-4 text-black">
                            <li class="mb-3">
                                <div class="unit unit-spacing-xs">
                                    <div class="unit-left"><span class="icon fa fa-phone"></span></div>
                                    <div class="unit-body">
                                        <a class="link-phone text-black" href="tel:+529999123456">+52 999 912 3456</a>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="unit unit-spacing-xs">
                                    <div class="unit-left"><span class="icon fa fa-clock-o"></span></div>
                                    <div class="unit-body">
                                        <p>Lun-Sáb: 07:00 AM – 05:00 PM</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="unit unit-spacing-xs">
                                    <div class="unit-left"><span class="icon fa fa-location-arrow"></span></div>
                                    <div class="unit-body">
                                        <a class="link-location text-black" href="#">Mérida, Yucatán, México</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- 2) Formulario de Contacto -->
                <div class="col-12 col-md-6 col-lg-6 footer-contact">
                    <div class="oh-desktop wow slideInDown" data-wow-delay="0s">
                        <h5 class="mb-3 contact-heading">Contáctanos</h5>
                        <p>Escríbenos tus dudas o comentarios y te responderemos a la brevedad.</p>

                        <form class="rd-form mt-4" method="POST" action="#">
                            {{-- @csrf --}}
                            <div class="form-wrap mb-3">
                                <input class="form-input" id="contact-name" type="text" name="name" required>
                                <label class="form-label" for="contact-name">Nombre</label>
                            </div>
                            <div class="form-wrap mb-3">
                                <input class="form-input" id="contact-email" type="email" name="email" required>
                                <label class="form-label" for="contact-email">Correo electrónico</label>
                            </div>
                            <div class="form-wrap mb-4">
                                <textarea class="form-input auto-grow" id="contact-message" name="message" rows="2" required></textarea>
                                <label class="form-label" for="contact-message">Mensaje</label>
                            </div>
                            <button class="button button-block button-white" type="submit">Enviar</button>
                        </form>

                        <div class="d-flex align-items-center mt-2 footer-social">
                            <span class="me-3">Síguenos</span>
                            <a href="#" class="fs-5 me-3"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="fs-5 me-3"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="fs-5"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>

    <div class="footer-variant-2-bottom-panel">
        <div class="container">
            <div class="group-sm group-sm-justify py-3">
                <p class="rights mb-0">
                    &copy; <span class="copyright-year"></span> Uh Luhmil Pakal. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </div>
</footer>
