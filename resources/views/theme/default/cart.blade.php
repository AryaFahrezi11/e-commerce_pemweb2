<x-layout>
    <x-slot name="title">Keranjang Belanja</x-slot>

    <style>
        body, html {
            margin: 0;
            padding: 0;
            background-color: #8B0000;
        }

        .container {
            background-color: transparent !important;
        }

        .category-card:hover,
        .product-card:hover,
        .card:hover {
            box-shadow: 0 0 20px rgba(255, 255, 0, 0.6) !important;
            transition: 0.3s ease;
        }

        .btn-outline-warning {
            color: #ffc107;
            border-color: #ffc107;
        }

        .btn-outline-warning:hover {
            background-color: #ffc107;
            color: #000;
        }
    </style>

    <div class="container my-5">
        <h1 class="mb-4 text-white">Keranjang Belanja</h1>

        @if($cart && count($cart->items))
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="card mb-3 bg-transparent border-warning text-white">
                        <div class="card-body p-3">
                            @forelse($cart->items as $item)
                                <div class="cart-item d-flex align-items-center mb-3 border-bottom pb-3 border-warning">
                                    <img src="{{ $item->itemable->image_url ?? 'https://via.placeholder.com/80?text=Product' }}"
                                         class="cart-img me-3 rounded" alt="{{ $item->itemable->name }}" style="width: 80px;">
                                    <div class="flex-grow-1">
                                        <h5 class="cart-item-name mb-1">{{ $item->itemable->name }}</h5>
                                        <p class="cart-item-price mb-0 text-warning">Rp.{{ number_format($item->itemable->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline-flex me-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="action" value="decrease" class="btn btn-outline-warning btn-sm" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                            <input type="text" name="quantity" value="{{ $item->quantity }}" class="form-control form-control-sm text-center mx-1 bg-dark text-white border-warning" style="width: 50px;" readonly>
                                            <button type="submit" name="action" value="increase" class="btn btn-outline-warning btn-sm">+</button>
                                        </form>

                                        <span class="cart-item-subtotal mb-0 me-3 fw-semibold text-warning">
                                            Rp.{{ number_format($item->itemable->price * $item->quantity, 0, ',', '.') }}
                                        </span>

                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">
                                    Keranjang belanja Anda kosong.
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <a href="{{ URL::to('/products') }}" class="btn btn-outline-warning mt-2"><i class="bi bi-arrow-left"></i> Lanjut Belanja</a>
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="col-lg-4">
                    <div class="card p-3 bg-transparent border-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Ringkasan Pesanan</h5>
                            <div class="d-flex justify-content-between total-section mb-2">
                                <span>Subtotal</span>
                                <span>Rp.{{ number_format($cart->calculatedPriceByQuantity(), 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between total-section fw-bold text-warning">
                                <span>Total</span>
                                <span>Rp.{{ number_format($cart->calculatedPriceByQuantity(), 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn btn-outline-warning w-100 mt-3">Lanjut ke Pembayaran</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center text-dark bg-light">
                Keranjang belanja Anda kosong.
            </div>
        @endif
    </div>
</x-layout>