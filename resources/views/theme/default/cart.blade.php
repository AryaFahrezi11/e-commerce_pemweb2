<x-layout>
    <x-slot name="title">Keranjang Belanja</x-slot>

    <style>
        body, html {
            margin: 0;
            padding: 50;
            background: linear-gradient(135deg, #4a0000, #8B0000);
            min-height: 100vh;
        }

        .container {
            background-color: transparent !important;
        }

        .category-card:hover,
        .product-card:hover,
        .card:hover {
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.4) !important;
            transition: 0.3s ease;
            transform: translateY(-3px);
        }

        .btn-outline-warning {
            color: #ffc107;
            border-color: #ffc107;
            transition: 0.3s ease;
        }

        .btn-outline-warning:hover {
            background-color: #ffc107;
            color: #000;
        }

        .card {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            border: 1px solid rgba(255, 215, 0, 0.4);
        }

        .cart-item-name {
            font-weight: 500;
            font-size: 1.1rem;
        }

        h1, h5 {
            font-weight: 600;
        }

        .btn-danger.btn-sm {
            transition: 0.3s ease;
        }

        .btn-danger.btn-sm:hover {
            background-color: #ff4d4d;
            border-color: #ff4d4d;
        }
    </style>

    <div class="container my-5">
        <h1 class="mb-4 text-center text-warning">Keranjang Belanja Anda</h1>

        @if($cart && count($cart->items))
            <div class="row g-4">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="card p-3">
                        @forelse($cart->items as $item)
                            <div class="cart-item d-flex align-items-center mb-3 pb-3 border-bottom border-warning">
                                <img src="{{ $item->itemable->image_url ?? 'https://via.placeholder.com/80?text=Product' }}"
                                     class="me-3 rounded shadow" alt="{{ $item->itemable->name }}" style="width: 80px; height: 80px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h5 class="cart-item-name mb-1 text-white">{{ $item->itemable->name }}</h5>
                                    <p class="cart-item-price mb-0 text-warning fw-semibold">Rp.{{ number_format($item->itemable->price, 0, ',', '.') }}</p>
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
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">
                                Keranjang belanja Anda kosong.
                            </div>
                        @endforelse

                        <a href="{{ URL::to('/products') }}" class="btn btn-outline-warning mt-3"><i class="bi bi-arrow-left"></i> Lanjut Belanja</a>
                    </div>
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="col-lg-4">
                    <div class="card p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="mb-3 text-warning">Ringkasan Pesanan</h5>
                            <div class="d-flex justify-content-between mb-2 text-white">
                                <span>Subtotal</span>
                                <span>Rp.{{ number_format($cart->calculatedPriceByQuantity(), 0, ',', '.') }}</span>
                            </div>
                            <hr class="border-warning">
                            <div class="d-flex justify-content-between fw-bold text-warning fs-5">
                                <span>Total</span>
                                <span>Rp.{{ number_format($cart->calculatedPriceByQuantity(), 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-outline-warning w-100 mt-4">Lanjut ke Pembayaran</a>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center text-dark bg-light mt-5">
                Keranjang belanja Anda kosong.
            </div>
        @endif
    </div>
</x-layout>
