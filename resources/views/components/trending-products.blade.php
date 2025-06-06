{{-- resources/views/components/trending-products.blade.php --}}
@props([
  /** 
   * Aquí llegará tu colección de productos cuando la tengas.
   * Por ahora, lo dejamos vacío.
   */
  'products' => []
])

<section class="section section-md bg-default">
  <div class="container">
    <div class="row row-40 justify-content-center">
      <div class="col-sm-8 col-md-7 col-lg-6 wow fadeInLeft" data-wow-delay="0s">
        {{-- Banner o contenido fijo --}}
        <div class="product-banner">
          <img src="{{ asset('images/home-banner-1-570x715.jpg') }}" alt="" width="570" height="715">
          <div class="product-banner-content">
            <div class="product-banner-inner" style="background-image: url('{{ asset('images/bg-brush.png') }}')">
              <h3 class="text-secondary-1">organic</h3>
              <h2 class="text-primary">Vegetables</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5 col-lg-6">
        <div class="row row-30 justify-content-center">
          @php
            // Si aún no tienes lógica real, mostramos X placeholders
            $items = count($products) ? $products : collect([
              (object)['img'=>'product-5-270x280.png','name'=>'Avocados','old'=>'$59.00','new'=>'$28.00'],
              (object)['img'=>'product-6-270x280.png','name'=>'Corn','new'=>'$27.00'],
              (object)['img'=>'product-8-270x280.png','name'=>'Artichokes','new'=>'$23.00'],
              (object)['img'=>'product-7-270x280.png','name'=>'Broccoli','new'=>'$25.00'],
            ]);
          @endphp

          @foreach($items as $p)
            <div class="col-sm-6 col-md-12 col-lg-6">
              <div class="oh-desktop">
                <article class="product product-2 box-ordered-item wow {{ in_array($loop->index, [0,3]) ? 'slideInRight' : 'slideInLeft' }}" data-wow-delay="0s">
                  <div class="unit flex-row flex-lg-column">
                    <div class="unit-left">
                      <div class="product-figure">
                        <img src="{{ asset('images/'.$p->img) }}" alt="{{ $p->name }}" width="270" height="280">
                        <div class="product-button">
                          <a class="button button-md button-white button-ujarak" href="#">Add to cart</a>
                        </div>
                      </div>
                    </div>
                    <div class="unit-body">
                      <h6 class="product-title"><a href="#">{{ $p->name }}</a></h6>
                      <div class="product-price-wrap">
                        @isset($p->old)
                          <div class="product-price product-price-old">{{ $p->old }}</div>
                        @endisset
                        <div class="product-price">{{ $p->new }}</div>
                      </div>
                      <a class="button button-sm button-secondary button-ujarak" href="#">Add to cart</a>
                    </div>
                  </div>
                </article>
              </div>
            </div>
          @endforeach

        </div>
      </div>
    </div>
  </div>
</section>
