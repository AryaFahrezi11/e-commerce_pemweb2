<x-layout>
    <x-slot name="title">Beranda</x-slot>

    <style>
        body, html {
            margin: 0;
            padding: 50;
            background-color: #8B0000;
        }

        .container {
            background-color: transparent !important;
        }

        /* Hover shadow untuk card */
        .category-card:hover,
        .product-card:hover {
            box-shadow: 0 0 20px rgba(255, 255, 0, 0.6) !important;
            transition: 0.3s ease;
        }

        /* Tombol kuning dan hover */
        .btn-outline-warning {
            color: #ffc107;
            border-color: #ffc107;
        }

        .btn-outline-warning:hover {
            background-color: #ffc107;
            color: #000;
        }
    </style>

   {{-- KATEGORI --}}
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-warning" style="font-size: 1.5rem;">Kategori Menu</h3>
        <a href="{{ url('/categories') }}" class="btn btn-outline-warning btn-sm">Lihat Semua Kategori</a>
    </div>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
        @foreach($categories as $category)
            <div class="col">
                <a href="{{ url('/category/'.$category->slug) }}" class="card text-decoration-none">
                    <div class="card category-card text-center h-100 py-3 border-0 shadow-sm">
                        <div class="mx-auto mb-3" style="
                            width: 140px;
                            height: 140px;
                            border-radius: 50%;
                            overflow: hidden;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            background: #f8f9fa;
                            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5);">
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" style="
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                                border-radius: 50%;">
                        </div>
                        <div class="card-body p-2">
                            <h6 class="card-title mb-1 text-dark">{{ $category->name }}</h6>
                            <p class="card-text text-muted small text-truncate">{{ $category->description }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

    {{-- PRODUK --}}
    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-warning" style="font-size: 1.5rem;">Produk Kami</h3>
            <a href="{{ url('/products') }}" class="btn btn-outline-warning btn-sm">Lihat Semua Produk</a>
        </div>
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card product-card h-100 shadow-sm">
                        <img 
                            src="{{ $product->image_url ?: 'https://via.placeholder.com/350x200?text=No+Image' }}" 
                            class="card-img-top" 
                            alt="{{ $product->name }}"
                            style="object-fit: cover; height: 200px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-truncate">{{ $product->description }}</p>
                            <div class="mt-auto">
                                <span class="fw-bold text-black">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-warning btn-sm float-end">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-info w-100 text-center">Belum ada produk pada kategori ini.</div>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if(method_exists($products, 'links'))
            <div class="d-flex justify-content-center w-100 mt-4">
                {{ $products->links('vendor.pagination.simple-bootstrap-5') }}
            </div>
        @endif
    </div>
</x-layout>
