<x-layout>
    <x-slot name="title">Keranjang Belanja</x-slot>

    <style>
    body {
        background: linear-gradient(135deg, #4a0000, #800000);
        color: #f8f9fa;
    }

    cart-card {
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(8px);
        border-radius: 12px;
        border: 1px solid rgba(255, 215, 0, 0.3);
        transition: 0.3s ease;
    }

    cart-card:hover {
        box-shadow: 0 0 15px rgba(255, 215, 0, 0.4);
        transform: translateY(-4px);
    }

    cart-item-name,
    cart-item-subtotal,
    card-title {
        color: #ffc107;
    }

    cart-item-price {
        color: #ddd;
    }

    btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
        transition: 0.3s ease;
    }

    btn-outline-warning:hover {
        background-color: #ffc107;
        color: #000;
    }

    btn-warning {
        background-color: #ffc107;
        color: #000;
        border: none;
    }

    btn-warning:hover {
        background-color: #e0ac00;
        color: #000;
    }

    alert-info {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 215, 0, 0.3);
        color: #ffc107;
    }

    total-section span {
        color: #ffc107;
    }

    btn-danger {
        background-color: #8b0000;
        border-color: #8b0000;
    }

    btn-danger:hover {
        background-color: #a50000;
        border-color: #a50000;
    }
</style>

    @if(session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="container my-5">
        <h1 class="mb-4 fw-bold text-center text-warning">Keranjang Belanja</h1>

        @if($cart && count($cart->items))
            <div class="row g-4">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm cart-card">
                        <div class="card-body p-3">
                            @forelse($cart->items as $item)
                                <div class="cart-item d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <img src="{{ $item->itemable->image_url ?? 'https://via.placeholder.com/80?text=Product' }}" class="cart-img me-3 rounded shadow-sm" alt="{{ $item->itemable->name }}">
                                    <div class="flex-grow-1">
                                        <h5 class="cart-item-name mb-1 fw-semibold">{{ $item->itemable->name }}</h5>
                                        <p class="cart-item-price mb-0 text-muted">Rp.{{ number_format($item->itemable->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline-flex align-items-center me-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="action" value="decrease" class="btn btn-outline-secondary btn-sm rounded-circle px-2" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                            <input type="text" name="quantity" value="{{ $item->quantity }}" class="form-control form-control-sm text-center mx-2" style="width: 50px;" readonly>
                                            <button type="submit" name="action" value="increase" class="btn btn-outline-secondary btn-sm rounded-circle px-2">+</button>
                                        </form>

                                        <span class="cart-item-subtotal mb-0 me-3 fw-semibold text-dark">Rp.{{ number_format($item->itemable->price * $item->quantity, 0, ',', '.') }}</span>

                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1">
                                                <i class="bi bi-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info text-center">
                                    Keranjang belanja Anda kosong.
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <a href="{{ URL::to('/products') }}" class="btn btn-outline-light mt-3"><i class="bi bi-arrow-left"></i> Lanjut Belanja</a>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm cart-card">
                        <div class="card-body">
                            <h5 class="card-title mb-3 fw-bold text-center">Ringkasan Pesanan</h5>
                            <div class="d-flex justify-content-between total-section mb-2">
                                <span>Subtotal</span>
                                <span>Rp.{{ number_format($cart->calculatedPriceByQuantity(), 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between total-section fw-bold fs-5">
                                <span>Total</span>
                                <span>Rp.{{ number_format($cart->calculatedPriceByQuantity(), 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn btn-warning text-dark w-100 mt-4 fw-semibold">Lanjut ke Pembayaran</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center mt-4">
                Keranjang belanja Anda kosong.
            </div>
        @endif
    </div>
</x-layout>
