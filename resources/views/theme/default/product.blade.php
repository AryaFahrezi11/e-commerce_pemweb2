<x-layout>
    <x-slot name="title"> {{$product->name}}</x-slot>
<style>
    body, html {
        margin: 0;
        padding: 50;
        background-color: #8B0000;
        color: white; /* semua teks default jadi putih */
    }

    .container,
    .row,
    .col-md-6,
    .col-12 {
        background-color: transparent !important;
    }

    h1, h3, h4, .fw-bold, .fw-semibold, strong, .card-title {
        color: white !important;
    }

    .text-muted, .list-group-item span, .list-group-item strong {
        color: white !important;
    }

    .list-group-item {
        background-color: transparent !important;
        border: none !important;
    }

    .bg-light {
        background-color: transparent !important;
        border: 1px solid #fff2 !important;
        color: white !important;
    }

    .form-control {
        background-color: #fff2 !important;
        color: #000 !important;
    }

    .badge.bg-secondary {
        background-color: #444 !important;
        color: white;
    }

    .card-body .text-truncate {
        color: #ccc !important;
    }

    .alert-info {
        background-color: #444;
        color: white;
        border: none;
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
                <div class=" shadow rounded p-3">
                     <img src="{{ $product->image_url ? asset($product->image_url) : 'https://via.placeholder.com/350x200?text=No+Image' }}"
     class="card-img-top"
     alt="{{ $product->name }}"
     style="object-fit: cover; height: 400px;">

                </div>
                <div class="mt-3">
                    <span class="badge bg-secondary">{{ $product->category->name ?? 'Kategori Tidak Diketahui' }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <h1 class="mb-2 fw-bold">{{ $product->name }}</h1>
                <div class="mb-3">
                    <span class="fs-4 text-success fw-semibold">Rp.{{ number_format($product->price, 0, ',', '.') }}</span>
                    @if($product->old_price)
                        <span class="text-muted text-decoration-line-through ms-2">Rp{{ number_format($product->old_price, 0, ',', '.') }}</span>
                    @endif
                </div>
                <div class="mb-4">
                    <p class="text-muted">{{ $product->description }}</p>
                </div>
                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="input-group" style="max-width: 320px;">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
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
                        <img src="{{ $relatedProduct->image_url ? asset($relatedProduct->image_url ) :'https://via.placeholder.com/350x200?text=No+Image' }}"
                             class="card-img-top"
                             alt="{{ $relatedProduct->name }}"
                             style="height: 200px; object-fit: cover; width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                            <p class="card-text text-black">{{ $relatedProduct->description }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                                <a href="{{ route('product.show', $relatedProduct->slug) }}" class="btn btn-outline-warning btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach 
            @if($relatedProducts->isEmpty())
                <div class="col">
                    <div class="alert alert-info">Tidak ada produk terkait.</div>
                </div>
            @endif
        </div>
    </div>
</x-layout>
