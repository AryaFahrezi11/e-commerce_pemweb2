<x-layout>
    <x-slot name="title">Beranda</x-slot>

    <style>
        body, html {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #4a0000, #8B0000);
            min-height: 100vh;
        }

        .container {
            background-color: transparent !important;
        }

        .category-card,
        .product-card {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            border: 1px solid rgba(255, 215, 0, 0.3);
            transition: 0.3s ease;
        }

        .category-card:hover,
        .product-card:hover {
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.4);
            transform: translateY(-4px);
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

        .card-title, .card-text, h3, h5 {
            color: #fff;
        }

        .text-muted {
            color: #ddd !important;
        }

        .category-image-container {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 215, 0, 0.5);
        }

        .category-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>

    {{-- KATEGORI --}}
    <div class="kategory container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-warning">Kategori Menu</h3>
            <a href="{{ url('/categories') }}" class="btn btn-outline-warning btn-sm">Lihat Semua Kategori</a>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($categories as $category)
                <div class="col">
                    <a href="{{ url('/category/'.$category->slug) }}" class="text-decoration-none">
                        <div class="card category-card text-center h-100 py-3 border-0 shadow-sm">
                            <div class="category-image-container mx-auto mb-3">
                                <img src="{{ $category->image }}" alt="{{ $category->name }}">
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 text-warning">{{ $category->name }}</h6>
                                <p class="card-text text-muted small text-truncate">{{ $category->description }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    {{-- PRODUK --}}
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-warning">Produk Kami</h3>
            <a href="{{ url('/products') }}" class="btn btn-outline-warning btn-sm">Lihat Semua Produk</a>
        </div>
        <div class="row g-3">
            @forelse($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card product-card h-100 shadow-sm">
                        <img 
                            src="{{ $product->image_url ?: 'https://via.placeholder.com/350x200?text=No+Image' }}" 
                            class="card-img-top" 
                            alt="{{ $product->name }}"
                            style="object-fit: cover; height: 180px; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-warning">{{ $product->name }}</h5>
                            <p class="card-text text-muted text-truncate">{{ $product->description }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-warning">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-warning btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-info text-center">Belum ada produk pada kategori ini.</div>
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
