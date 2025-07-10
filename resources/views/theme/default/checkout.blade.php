<x-layout>
    <x-slot name="title">Checkout</x-slot>

    <style>
        body, html {
            margin: 0;
            padding: 50;
            background: linear-gradient(135deg, #4a0000, #8B0000);
            min-height: 100vh;
        }

        .form-label, h4, h5, label {
            color: white !important;
        }

        .btn-outline-warning {
            color: #ffc107;
            border-color: #ffc107;
            transition: 0.3s ease;
        }

        .btn-outline-warning:hover,
        .btn-warning:hover {
            background-color: #ffc107;
            color: #000;
        }

        .card {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            border: 1px solid rgba(255, 215, 0, 0.4);
            transition: 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.4);
            transform: translateY(-3px);
        }

        .hidden {
            display: none;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #ffc107;
            color: white;
        }

        .form-control::placeholder {
            color: #ddd;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #ffd700;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.4);
            color: white;
        }
    </style>

    <div class="container my-5">
        <div class="row g-4">
            <!-- Form Pemesanan -->
            <div class="col-md-6">
                <div class="card p-4">
                    <h4 class="mb-4 text-warning text-center">Data Pemesan</h4>
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No. HP</label>
                            <input type="text" name="phone" class="form-control" id="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat Lengkap</label>
                            <textarea name="address" class="form-control" id="address" rows="3" placeholder="Jl. Mawar No.123, RT/RW 04/05" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">Kota</label>
                                <input type="text" name="city" class="form-control" id="city" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="province" class="form-label">Provinsi</label>
                                <input type="text" name="province" class="form-control" id="province" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="postal_code" class="form-label">Kode Pos</label>
                                <input type="text" name="postal_code" class="form-control" id="postal_code" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Catatan Tambahan</label>
                            <textarea name="note" class="form-control" rows="2" placeholder="Contoh: tanpa es, sambalnya pisah..."></textarea>
                        </div>

                        <h5 class="mt-4 mb-3 text-warning">Metode Pembayaran</h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="cod" value="COD" checked>
                            <label class="form-check-label" for="cod">Bayar di Tempat (COD)</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="transfer" value="Transfer">
                            <label class="form-check-label" for="transfer">Transfer Bank (BCA/Mandiri)</label>
                        </div>

                        <div id="bankDetails" class="hidden mt-3">
                            <div class="mb-3">
                                <label for="bank_name" class="form-label">Nama Bank</label>
                                <input type="text" name="bank_name" class="form-control" id="bank_name" placeholder="Contoh: BCA, Mandiri">
                            </div>
                            <div class="mb-3">
                                <label for="account_number" class="form-label">Nomor Rekening</label>
                                <input type="text" name="account_number" class="form-control" id="account_number" placeholder="1234567890">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 mt-4">Pesan Sekarang</button>
                    </form>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="col-md-6">
                <div class="card p-4 text-white h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title mb-3 text-warning">Ringkasan Pesanan</h5>

                            @foreach($cart->items as $item)
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <div>
                                        <strong>{{ $item->itemable->name }}</strong><br>
                                        <small>{{ $item->quantity }} × Rp.{{ number_format($item->itemable->price, 0, ',', '.') }}</small>
                                    </div>
                                    <span>Rp.{{ number_format($item->itemable->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach

                            @php
                                $subtotal = $cart->calculatedPriceByQuantity();
                                $shippingCost = $subtotal >= 50000 ? 0 : 5000;
                            @endphp

                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>Rp.{{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkir</span>
                                <span>Rp.{{ number_format($shippingCost, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold text-warning fs-5">
                                <span>Total</span>
                                <span>Rp.{{ number_format($subtotal + $shippingCost, 0, ',', '.') }}</span>
                            </div>

                            @if($subtotal < 50000)
                                <div class="alert alert-info text-dark mt-3">
                                    Gratis ongkir untuk pesanan di atas Rp. 50.000!
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-warning mt-4"><i class="bi bi-arrow-left"></i> Kembali ke Keranjang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Toggle Form Transfer Bank --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const cod = document.getElementById('cod');
            const transfer = document.getElementById('transfer');
            const bankForm = document.getElementById('bankDetails');

            function toggleBank() {
                bankForm.classList.toggle('hidden', !transfer.checked);
            }

            cod.addEventListener('change', toggleBank);
            transfer.addEventListener('change', toggleBank);
        });
    </script>
</x-layout>
