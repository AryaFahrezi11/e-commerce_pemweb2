<x-layout>
    <x-slot name="title">{{ $product->name }}</x-slot>

    <style>
        body, html {
            margin: 0;
            padding: 50;
            background: linear-gradient(135deg, #4a0000, #8B0000);
            color: white;
            min-height: 100vh;
        }

        .container {
            background: transparent !important;
        }

        h1, h3, h4, h5, strong {
            color: #ffc107 !important;
        }

        p, .card-text, .text-black, .text-muted {
            color: #ddd !important;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #000;
            border: none;
        }

        .btn-warning:hover {
            background-color: #000;
            color: #ffc107;
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

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 215, 0, 0.3);
        }

        .form-control::placeholder {
            color: #ccc;
        }

        .card {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 12px;
            transition: 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
            transform: translateY(-4px);
        }

        .badge.bg-secondary {
            background-color: #555 !important;
            color: #ffc107 !important;
        }

        .bg-light {
            background: rgba(0, 0, 0, 0.4) !important;
            border: 1px solid rgba(255, 215, 0, 0.2) !important;
            color: #ffc107 !important;
        }

        .alert-info {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 215, 0, 0.2);
            color: #ffc107;
        }

        .list-group-item {
            background: rgba(0, 0, 0, 0.4) !important;
            border: 1px solid rgba(255, 215, 0, 0.1) !important;
            color: #ddd !important;
        }

        .list-group-item strong {
            color: #ffc107 !important;
        }
    </style>

    @if(session('error'))
        <div class="container mt-4">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="container my-5">
        <div class="row g-5 align-items-start">
            <div class="col-md-6">
                <div class="shadow rounded p-2">
                    <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://via.placeholder.com/350x200?text=No+Image' }}"
                         class="card-img-top rounded"
                         alt="{{ $product->name }}"
                         style="object-fit: cover; height: 400px; width: 100%;">
                </div>
                <div class="mt-3">
                    <span class="badge bg-secondary">{{ $product->category->name ?? 'Kategori Tidak Diketahui' }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <h1 class="mb-2">{{ $product->name }}</h1>
                <div class="mb-3">
                    <span class="fs-4 fw-bold text-warning">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @if($product->old_price)
                        <span class="text-decoration-line-through ms-2">Rp {{ number_format($product->old_price, 0, ',', '.') }}</span>
                    @endif
                </div>
                <div class="mb-4">
                    <p>{{ $product->description }}</p>
                </div>
                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="input-group" style="max-width: 320px;">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}" placeholder="Jumlah">
                        <button class="btn btn-warning" type="submit">
                            <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
                        </button>
                    </div>
                </form>
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><strong>Stok:</strong></span>
                        <span class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $product->stock > 0 ? $product->stock : 'Habis' }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><strong>Kategori:</strong></span>
                        <span>{{ $product->category->name ?? '-' }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <h4 class="mb-3">Deskripsi Produk</h4>
                <div class="bg-light p-4 rounded shadow-sm">
                    {!! nl2br(e($product->long_description ?? $product->description)) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h3 class="mb-4">Produk Lainnya</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($relatedProducts as $relatedProduct)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $relatedProduct->image_url ? asset($relatedProduct->image_url) : 'https://via.placeholder.com/350x200?text=No+Image' }}"
                             class="card-img-top rounded-top"
                             alt="{{ $relatedProduct->name }}"
                             style="height: 200px; object-fit: cover; width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                            <p class="card-text">{{ $relatedProduct->description }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-warning">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                                <a href="{{ route('product.show', $relatedProduct->slug) }}" class="btn btn-outline-warning btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if($relatedProducts->isEmpty())
                <div class="col">
                    <div class="alert alert-info text-center">Tidak ada produk terkait.</div>
                </div>
            @endif
        </div>
    </div>
</x-layout>
