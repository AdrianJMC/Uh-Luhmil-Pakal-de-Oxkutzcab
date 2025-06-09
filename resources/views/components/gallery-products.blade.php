<div class="section section-md bg-default section-top-image">
    <div class="container">
        <h2 class="oh slideInUp text-center mb-5" data-wow-delay="0s">
            Galería de Hortalizas y Cítricos
        </h2>
        <div class="row row-30">
            @foreach ($items as $g)
                <div class="col-sm-6 col-lg-4">
                    <article
                        class="thumbnail thumbnail-mary thumbnail-sm wow {{ $loop->index % 2 ? 'slideInUp' : 'slideInLeft' }}"
                        data-wow-delay="0s">
                        <div class="thumbnail-mary-figure">
                            <img src="{{ secure_asset('images/' . $g['img']) }}" alt="{{ $g['title'] }}" loading="lazy"
                                width="370" height="303" class="rounded" />
                        </div>
                        <div class="thumbnail-mary-caption text-center mt-2">
                            <a href="{{ $g['slug'] ?? '#' }}" class="stretched-link text-decoration-none">
                                <h4 class="thumbnail-mary-title mt-2">{{ $g['title'] }}</h4>
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</div>
