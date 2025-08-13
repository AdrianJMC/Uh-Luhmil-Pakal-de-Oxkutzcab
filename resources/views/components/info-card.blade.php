@php
    if (!function_exists('embedSrc')) {
        function embedSrc($url)
        {
            $url = trim($url);
            $origin = rtrim(config('app.url') ?? request()->getSchemeAndHttpHost(), '/');

            $p = parse_url($url);
            $host = $p['host'] ?? '';
            $path = $p['path'] ?? '';
            parse_str($p['query'] ?? '', $q);

            // YouTube
            if (stripos($host, 'youtu.be') !== false) {
                $id = preg_replace('/[^A-Za-z0-9_-]/', '', ltrim($path, '/'));
                return strlen($id) === 11
                    ? "https://www.youtube-nocookie.com/embed/{$id}?rel=0&modestbranding=1&playsinline=1&enablejsapi=1&origin=" .
                            urlencode($origin)
                    : null;
            }
            if (stripos($host, 'youtube.com') !== false) {
                if (!empty($q['v']) && preg_match('/^[A-Za-z0-9_-]{11}$/', $q['v'])) {
                    $id = $q['v'];
                    return "https://www.youtube-nocookie.com/embed/{$id}?rel=0&modestbranding=1&playsinline=1&enablejsapi=1&origin=" .
                        urlencode($origin);
                }
                if (preg_match('~/(embed|shorts)/([A-Za-z0-9_-]{11})~', $path, $m)) {
                    $id = $m[2];
                    return "https://www.youtube-nocookie.com/embed/{$id}?rel=0&modestbranding=1&playsinline=1&enablejsapi=1&origin=" .
                        urlencode($origin);
                }
            }

            // Vimeo
            if (stripos($host, 'vimeo.com') !== false) {
                if (preg_match('~/video/(\d+)~', $path, $m) || preg_match('~/(\d+)$~', $path, $m)) {
                    return "https://player.vimeo.com/video/{$m[1]}";
                }
            }
            if (preg_match('/^\d{6,}$/', $url)) {
                // ID numérico "pelón"
                return "https://player.vimeo.com/video/{$url}";
            }

            return null;
        }
    }
@endphp



@props(['image', 'title' => '', 'text' => '', 'delay' => 0, 'videoId' => null])

<div class="col-12 col-md-6 col-lg-3 mb-5">
    @if ($videoId)
        @php $src = embedSrc($videoId); @endphp
        @if ($src)
            <div class="card info-card h-100 position-relative border-0 bg-transparent p-0 overflow-hidden"
                data-video-id="{{ $src }}" data-video-src="{{ $src }}" data-aos="fade-up"
                @if ($delay) data-aos-delay="{{ $delay }}" @endif style="cursor:pointer;">
                <img src="{{ $image }}" class="w-100" alt="Vídeo informativo">
                <span
                    class="position-absolute top-50 start-50 translate-middle fs-1 text-white bi bi-play-circle-fill"></span>
            </div>
        @else
            {{-- si el link no es válido, cae a tarjeta normal --}}
            <div class="card info-card h-100" data-aos="fade-up"
                @if ($delay) data-aos-delay="{{ $delay }}" @endif>
                <img src="{{ $image }}" class="card-img-top" alt="{{ $title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $title }}</h5>
                    @if ($text)
                        <p class="card-text">{{ $text }}</p>
                    @endif
                </div>
            </div>
        @endif
    @else
        {{-- tu rama "imagen + texto" tal cual --}}
        <div class="card info-card h-100" data-aos="fade-up"
            @if ($delay) data-aos-delay="{{ $delay }}" @endif>
            <img src="{{ $image }}" class="card-img-top" alt="{{ $title }}">
            <div class="card-body">
                <h5 class="card-title">{{ $title }}</h5>
                @if ($text)
                    <p class="card-text">{{ $text }}</p>
                @endif
            </div>
        </div>
    @endif
</div>
