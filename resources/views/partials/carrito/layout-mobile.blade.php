{{-- Mobile layout --}}
<div class="mobile-stack d-flex d-md-none">
    <div class="left">
        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
        <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="update-form">
            @csrf
            <button type="button" class="btn btn-outline-secondary btn-update-cart" data-action="decrease"
                data-id="{{ $key }}">
                <i class="fas fa-minus"></i>
            </button>
            <input type="text" class="quantity-display"
                value="{{ fmod($item['quantity'], 1) === 0.0 ? (int) $item['quantity'] : number_format($item['quantity'], 1) }}"
                readonly>
            <button type="button" class="btn btn-outline-secondary btn-update-cart" data-action="increase"
                data-id="{{ $key }}">
                <i class="fas fa-plus"></i>
            </button>
        </form>
    </div>
    <div class="right">
        <div class="info">
            <h5>{{ $item['name'] }}</h5>
            <p class="text-muted mb-1">{{ $item['agrupacion'] }}</p>
            <small class="text-muted">${{ number_format($item['price'], 2) }} por
                Tonelada</small>
        </div>

        <div class="actions-row">
            <form action="{{ route('cart.remove', $key) }}" method="POST">
                @csrf
                <button type="submit" class="btn-eliminar-carrito" aria-label="Eliminar producto">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
            <div class="item-total">
                ${{ number_format($item['price'] * $item['quantity'], 2) }}
            </div>
        </div>
    </div>
</div>
