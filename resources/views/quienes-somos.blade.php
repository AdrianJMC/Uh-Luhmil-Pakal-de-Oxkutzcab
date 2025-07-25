@php $mostrarLoader = true; @endphp

@extends('layouts.app')

@section('title', 'Quiénes somos | Uh Luhmil Pakal')

@section('content')
    {{-- Hero “Quiénes somos” – sin diagonales y con contenido un poco más arriba --}}
    <section class="section section-md bg-light pt-2 pb-5">
        <div class="container mt-n3">
            <!-- Título: menos margen arriba y casi nada de padding-bottom -->
            <h2 class="h2 text-center p-3 mt-5">¿Quiénes somos?</h2>

            <div class="row gx-4 gy-5 align-items-center">
                <!-- Texto: en móvil primero, en desktop a la derecha -->
                <div class="col-12 col-md-6 order-1 order-md-2">
                    <p>
                        En <strong>Uh Luhmil Pakal</strong> somos una agrupación de productores de Oxkutzcab que, combinando
                        métodos agrícolas tradicionales con tecnología de vanguardia, cultivamos hortalizas y cítricos de
                        calidad
                        superior. Nuestro modelo colaborativo impulsa el desarrollo rural, protege nuestros recursos
                        naturales y
                        asegura la trazabilidad desde la parcela hasta tu mesa.
                    </p>

                    <!-- Datos rápidos -->
                    <!-- Contenedor que centra todo -->
                    <div class="text-center mt-4">
                        <!-- UL como inline-block + texto alineado a la izquierda -->
                        <ul class="list-unstyled d-inline-block text-start">
                            <li class="mb-2 d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span>Más de 50 productores asociados</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span>200 ha cultivadas anualmente</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span>100 toneladas enviadas al año</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Imagen: en móvil sale de último, en desktop primero -->
                <div class="col-12 col-md-6 order-2 order-md-1 mt-4 mt-md-0">
                    <img src="{{ asset('images/IMG_quines_somos.jpg') }}" alt="Productores de Uh Luhmil Pakal"
                        class="img-fluid rounded shadow-sm p-2" style="border: 3px solid #000000;">
                </div>
            </div>
        </div>

        <!-- Divider de olas -->
        <div class="shape-divider-bottom-quienes-somos">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width:100%; height:60px;">
                <path d="M0,40
                                                     C300,80 500,0 800,40
                                                     C1000,80 1200,20 1200,40
                                                     L1200,120
                                                     L0,120
                                                     Z" fill="#2e7d32" />
            </svg>
        </div>
    </section>


    {{-- Nuestra historia --}}
    <section class="section section-md py-5" style="background: #ffffff;">
        <div class="container">
            <h2 class="p-4 h2 text-center mb-3 mt-5">Nuestra historia</h2>

            {{-- Intro --}}
            <p class="text-center mb-5">
                Uh Luhmil Pakal nació en 2017 cuando un grupo de 12 productores de Oxkutzcab, preocupados por la
                sostenibilidad y la mejora de sus cosechas, se reunió tras participar en un taller de agroinnovación.
                Motivados por compartir conocimientos y reducir costos, formalizaron la agrupación un año después,
                consolidando su primera planta de clasificación apoyados por la comunidad local.
            </p>

            {{-- Timeline horizontal simplificado --}}
            <div class="row timeline position-relative align-items-start mt-5">
                {{-- Línea base: ahora la convertimos en un div con clase, para poder posicionarla --}}
                <div class="col-12 d-none d-md-block position-relative">
                    <hr class="timeline-hr" />
                </div>

                {{-- 2017 – Taller de agroinnovación: 🌳 --}}
                <div class="col-12 col-md text-center mt-0 mt-md-0">
                    <div class="timeline-icon bg-success text-black rounded-circle d-inline-flex align-items-center justify-content-center mb-2 mb-md-0"
                        style="width: 2.5rem; height: 2.5rem; font-size: 2rem;">
                        <!-- Ícono de árbol (Font Awesome Free 5.15.4) -->
                        <i class="fas fa-tree"></i>
                    </div>
                    <h5 class="fw-bold mb-2 mt-5">2017</h5>
                    <p class="small mb-4 mb-md-0">
                        Taller de agroinnovación reúne a 12 productores.
                    </p>
                </div>

                {{-- 2018 – Registro oficial y planta: 🏭 --}}
                <div class="col-12 col-md text-center mt-5 mt-md-0">
                    <div class="timeline-icon bg-success text-black rounded-circle d-inline-flex align-items-center justify-content-center mb-2 mb-md-0"
                        style="width: 2.5rem; height: 2.5rem; font-size: 2rem;">
                        <i class="fas fa-industry"></i>
                    </div>
                    <h5 class="fw-bold mb-2 mt-5">2018</h5>
                    <p class="small mb-4 mb-md-0">
                        Registro oficial con 15 socios y apertura de planta en Mérida.
                    </p>
                </div>

                {{-- 2019 – Certificación orgánica: 🏅 --}}
                <div class="col-12 col-md text-center mt-5 mt-md-0">
                    <div class="timeline-icon bg-success text-black rounded-circle d-inline-flex align-items-center justify-content-center mb-2 mb-md-0"
                        style="width: 2.5rem; height: 2.5rem; font-size: 2rem;">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h5 class="fw-bold mb-2 mt-5">2019</h5>
                    <p class="small mb-4 mb-md-0">
                        Primera certificación orgánica para 30 hectáreas.
                    </p>
                </div>

                {{-- 2020 – Plataforma en línea: 💻 --}}
                <div class="col-12 col-md text-center mt-5 mt-md-0">
                    <div class="timeline-icon bg-success text-black rounded-circle d-inline-flex align-items-center justify-content-center mb-2 mb-md-0"
                        style="width: 2.5rem; height: 2.5rem; font-size: 2rem;">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h5 class="fw-bold mb-2 mt-5">2020</h5>
                    <p class="small mb-4 mb-md-0">
                        Plataforma de pedidos en línea con trazabilidad digital.
                    </p>
                </div>

                {{-- 2021 – Alianza con la UADY: 🎓 --}}
                <div class="col-12 col-md text-center mt-5 mt-md-0">
                    <div class="timeline-icon bg-success text-black rounded-circle d-inline-flex align-items-center justify-content-center mb-2 mb-md-0"
                        style="width: 2.5rem; height: 2.5rem; font-size: 2rem;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h5 class="fw-bold mb-2 mt-5">2021</h5>
                    <p class="small mb-4 mb-md-0">
                        Alianza con la UADY e incorporación de cítricos.
                    </p>
                </div>

                {{-- 2022 – Expansión de envíos: 🚚 --}}
                <div class="col-12 col-md text-center mt-5 mt-md-0">
                    <div class="timeline-icon bg-success text-black rounded-circle d-inline-flex align-items-center justify-content-center mb-2 mb-md-0"
                        style="width: 2.5rem; height: 2.5rem; font-size: 2rem;">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h5 class="fw-bold mb-2 mt-5">2022</h5>
                    <p class="small mb-4 mb-md-0">
                        Expansión de envíos al Bajío y CDMX.
                    </p>
                </div>

                {{-- 2023 – Reconocimiento por sostenibilidad: 🏆 --}}
                <div class="col-12 col-md text-center mt-5 mt-md-0">
                    <div class="timeline-icon bg-success text-black rounded-circle d-inline-flex align-items-center justify-content-center mb-2 mb-md-0"
                        style="width: 2.5rem; height: 2.5rem; font-size: 2rem;">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h5 class="fw-bold mb-2 mt-5">2023</h5>
                    <p class="small mb-4 mb-md-0">
                        Reconocimiento estatal por sostenibilidad.
                    </p>
                </div>
            </div>

        </div>
    </section>


    {{-- CTA “Únete como proveedor” con borde y parallax --}}
    <section class="section text-center border border-success rounded overflow-hidden my-5">
        <div class="parallax-container" data-parallax-img="{{ asset('images/IMG_promover_compra.png') }}">
            <div class="parallax-content section-xl section-inset-custom-1 context-dark bg-overlay-40">
                <div class="container">
                    <h2 class="oh font-weight-normal">
                        <span class="d-inline-block wow slideInDown" data-wow-delay="0s">
                            ¿Eres una agrupacion y estas intereseado en formar parte?
                        </span>
                    </h2>
                    <a class="button button-primary button-icon button-icon-left button-ujarak wow fadeInUp"
                        href="{{ route('agrupaciones.create') }}" data-wow-delay=".1s">
                        Únete
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- resources/views/partials/alianzas.blade.php --}}
    <section class="section section-md bg-white py-5">
        <div class="container text-center">
            <h2 class="h2 mb-4">Alianzas Institucionales</h2>
            <p class="mb-4">
                Desde nuestra fundación, hemos forjado vínculos sólidos con instituciones educativas y organismos públicos
                para impulsar el desarrollo agropecuario y fomentar la innovación en el sector.
            </p>
            <p class="mb-4">
                El 10 de septiembre de 2023 firmamos un convenio de colaboración con el Instituto Tecnológico Superior
                del Sur de Yucatán (ITSSY), cuyo objetivo principal es:
            </p>
            <ul class="list-unstyled d-inline-block text-start" style="max-width: 600px;">
                <li class="mb-2">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Facilitar prácticas profesionales y proyectos de investigación para estudiantes de agroindustria.
                </li>
                <li class="mb-2">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Impulsar la transferencia de tecnología y metodologías sustentables a nuestros productores.
                </li>
                <li class="mb-2">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Desarrollar programas de formación continua y talleres de certificación en agricultura orgánica.
                </li>
                <li>
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Promover ferias y eventos conjuntos para la comercialización de productos locales.
                </li>
            </ul>
            <p class="small text-muted mt-3">
                Hasta la fecha, más de <strong>150</strong> alumnos han participado en prácticas profesionales,
                y hemos beneficiado a más de <strong>62</strong> productores de nuestros <strong>5,000</strong> socios.
            </p>

            {{-- Logos de alianzas --}}
            <div class="row justify-content-center align-items-center mt-5">
                <div class="col-6 col-md-3 mb-4">
                    <img src="{{ asset('images/itssy-logo.png') }}" alt="Logo ITSSY" class="img-fluid"
                        style="max-height: 150px;">
                    <p class="mt-2">ITSSY</p>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <img src="{{ asset('images/sefoe-logo.png') }}" alt="Logo SEFOE" class="img-fluid"
                        style="max-height: 500px;">
                    <p class="mt-2">Secretaría de Fomento Económico</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/loader.js') }}"></script>
@endpush
