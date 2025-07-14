<x-layout>
    <x-slot name="title"> Products</x-slot>
  
    <style>
        body, html {
            margin: 0;
            padding: 50;
            background: linear-gradient(135deg, #4a0000, #8B0000);
            color: white;
            min-height: 100vh;
        }

        .container {
            background-color: transparent !important;
        }

        h3, h5, .fw-bold {
            color: #ffc107 !important;
        }

        p, .card-text, .text-black {
            color: #ddd !important;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #000;
            border: none;
            transition: 0.3s ease;
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

        .alert-info {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 215, 0, 0.3);
            color: #ffc107;
        }
    </style>
    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
           <h3 class="text-center " style="font-size: 1.5rem"> 
    <i class="bi bi-grid-fill"></i> Kategori Produk
</h3>

            <form action="{{ url()->current() }}" method="GET" class="d-flex" style="max-width: 300px;">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-warning">Cari</button>
            </form>
        </div>
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://via.placeholder.com/350x200?text=No+Image' }}" 
                             class="card-img-top" 
                             alt="{{ $product->name }}"
                             style="height: 200px; object-fit: cover; width: 100%;">

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
                    <div class="alert alert-info">Belum ada produk pada kategori ini.</div>
                </div>
            @endforelse

            <div class="d-flex justify-content-center w-100 mt-4">
                {{ $products->links('vendor.pagination.simple-bootstrap-5') }}
            </div>
        </div>
    </div>
</x-layout>
