{{-- resources/views/partials/counters.blade.php --}}
<section class="section">
  <div class="parallax-container" data-parallax-img="images/IMG_estadisticas.png">
    <div class="parallax-content section-xl context-dark bg-overlay-68">
      <div class="container">
        <div class="row row-lg row-50 justify-content-center border-classic border-classic-big">
          @foreach ([
            ['n' => '12', 'icon' => 'fl-bigmug-line-trophy55', 'label' => 'Awards'],
            ['n' => '2',  'suffix' => 'k',       'icon' => 'fl-bigmug-line-up104',  'label' => 'Products'],
            ['n' => '679','icon' => 'fl-bigmug-line-sun81',  'label' => 'Happy Clients'],
            ['n' => '13', 'icon' => 'fl-bigmug-line-user143','label' => 'Farmers'],
          ] as $c)
            <div class="col-sm-6 col-md-5 col-lg-3 wow fadeInLeft" data-wow-delay="0s">
              <div class="counter-creative">
                <div class="counter-creative-number">
                  <span class="counter">{{ $c['n'] }}</span>
                  @isset($c['suffix'])
                    <span class="symbol">{{ $c['suffix'] }}</span>
                  @endisset
                  <span class="icon counter-creative-icon {{ $c['icon'] }}"></span>
                </div>
                <h6 class="counter-creative-title">{{ $c['label'] }}</h6>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
