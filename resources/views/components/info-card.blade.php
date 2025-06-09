@props(['image','title'=>'','text'=>'','delay'=>0,'videoId'=>null])

<div class="col-12 col-md-6 col-lg-3 mb-5">
  @if($videoId)
    <div class="card info-card h-100 position-relative border-0 bg-transparent p-0 overflow-hidden"
         data-aos="fade-up" @if($delay) data-aos-delay="{{ $delay }}" @endif
         data-video-id="{{ $videoId }}" style="cursor:pointer;">
      <img src="{{ secure_asset('storage/'.$image) }}" class="w-100" alt="Vídeo informativo">
      <span class="position-absolute top-50 start-50 translate-middle fs-1 text-white bi bi-play-circle-fill"></span>
    </div>
  @else
    <div class="card info-card h-100" data-aos="fade-up" @if($delay) data-aos-delay="{{ $delay }}" @endif>
      <img src="{{ secure_asset('storage/'.$image) }}" class="card-img-top" alt="{{ $title }}">
      <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        @if($text)
          <p class="card-text">{{ $text }}</p>
        @endif
      </div>
    </div>
  @endif
</div>
