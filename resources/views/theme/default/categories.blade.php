<x-layout>
    <x-slot name="title">Categories</x-slot>

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

        h3 {
            color: #ffc107 !important;
        }

        .card.category-card {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 16px;
            transition: 0.3s ease;
            color: white;
            text-align: center;
        }

        .card.category-card:hover {
            box-shadow: 0 0 12px rgba(255, 215, 0, 0.3);
            transform: translateY(-4px);
        }

        .card-title {
            color: #ffc107 !important;
        }

        .card-text {
            color: #ddd !important;
        }

        .category-image-circle {
            width: 140px;
            height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid rgba(255, 215, 0, 0.3);
            transition: 0.3s ease;
        }

        .category-image-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        a.text-decoration-none:hover {
            text-decoration: none !important;
        }

        .pagination {
            --bs-pagination-color: #ffc107;
            --bs-pagination-hover-color: #000;
            --bs-pagination-hover-bg: #ffc107;
            --bs-pagination-focus-color: #000;
            --bs-pagination-focus-bg: #ffc107;
            --bs-pagination-active-color: #000;
            --bs-pagination-active-bg: #ffc107;
            --bs-pagination-border-color: rgba(255, 215, 0, 0.3);
        }
    </style>

    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
           <h3 class="text-center " style="font-size: 1.5rem"> 
    <i class="bi bi-grid-fill"></i> Kategori Produk
</h3>

        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($categories as $category)
                <div class="col">
                    <a href="{{ URL::to('/category/'.$category->slug) }}" class="text-decoration-none">
                        <div class="card category-card h-100 py-3 border-0 shadow-sm">
                            <div class="mx-auto mb-2 category-image-circle">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1">{{ $category->name }}</h6>
                                <p class="card-text small text-truncate">{{ $category->description }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center w-100 mt-4">
            {{ $categories->links('vendor.pagination.simple-bootstrap-5') }}
        </div>
    </div>
</x-layout>
