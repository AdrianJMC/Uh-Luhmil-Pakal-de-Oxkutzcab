<div class="section section-md bg-default section-top-image">
    <div class="container">
        <h2 class="oh slideInUp text-center mb-5" data-wow-delay="0s">
            {{ $title ?? 'Catálogos Disponibles' }}
        </h2>
        <div class="row row-30">
            @forelse ($items as $catalogo)
                <div class="col-sm-6 col-lg-4 wow {{ $loop->index % 2 ? 'slideInUp' : 'slideInLeft' }}" data-wow-delay="{{ $loop->index * 0.1 }}s">
                    <article class="thumbnail thumbnail-mary thumbnail-sm" style="cursor:pointer"
                        onclick="abrirModalAgrupaciones({{ $catalogo->id }}, '{{ addslashes($catalogo->nombre) }}')">
                        <div class="thumbnail-mary-figure">
                            <img src="{{ $catalogo->imagen_url }}" alt="{{ $catalogo->nombre }}" loading="lazy"
                                width="370" height="303" class="rounded" />
                        </div>
                        <div class="thumbnail-mary-caption text-center mt-2">
                            <h4 class="thumbnail-mary-title mt-2">{{ $catalogo->nombre }}</h4>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No hay catálogos disponibles.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>