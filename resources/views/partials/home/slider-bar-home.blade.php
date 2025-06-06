{{-- resources/views/partials/slider-bar-home.blade.php --}}
<section class="section swiper-container swiper-slider swiper-slider-modern"
         data-loop="true" data-autoplay="5000"
         data-simulate-touch="true" data-nav="true"
         data-slide-effect="fade">
  <div class="swiper-wrapper text-left">
    @foreach($slides as $slide)
      <div class="swiper-slide context-dark"
           data-slide-bg="{{ asset('storage/'.$slide->imagen_ruta) }}">
        <div class="swiper-slide-caption">
          <div class="container">
            <div class="row justify-content-center justify-content-xxl-start">
              <div class="col-md-10 col-xxl-6">
                <div class="slider-modern-box">
                  <h1 class="slider-modern-title">
                    <span
                      data-caption-animate="slideInDown"
                      data-caption-delay="0"
                    >{{ $slide->titulo }}</span>
                  </h1>
                  <p
                    data-caption-animate="fadeInRight"
                    data-caption-delay="400"
                  >{!! nl2br(e($slide->descripcion)) !!}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>
  <div class="swiper-pagination swiper-pagination-style-2"></div>
</section>
