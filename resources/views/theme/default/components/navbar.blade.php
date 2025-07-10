<!-- Tambahkan ini di <head> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div>
    <style>
        .nav-link:hover,
        .dropdown-item:hover {
            color: #ffd700 !important;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .btn-outline-light:hover {
            background-color: #ffffff !important;
            color: #3498db !important;
        }

        /* Tambahkan margin ke body untuk hindari konten tertutup navbar */
        body {
            padding-top: 80px; /* Sesuaikan dengan tinggi navbar */
        }
    </style>

   {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg shadow-sm fixed-top"
        style="background: linear-gradient(135deg, rgba(17, 17, 17, 0.85) 0%, rgba(92, 8, 8, 0.8) 94%, rgba(87, 8, 8, 0.8) 100%);
        padding: 14px 24px; transition: all 0.3s ease; z-index: 1030;">
        <div class="container">
            <a class="navbar-brand fw-bold text-white fs-4" href="/">Irish Koff and Bakery</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-medium" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-medium" href="/categories">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-medium" href="/products">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning fw-bold" href="{{ route('orders.index') }}">Pesanan Saya</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <x-cart-icon></x-cart-icon>
                    @if(auth()->guard('customer')->check())
                        <div class="dropdown">
                            <a class="btn btn-outline-light dropdown-toggle px-3" href="#" role="button"
                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::guard('customer')->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li>
                                    <form method="POST" action="{{ route('customer.logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a class="btn btn-outline-light px-3" href="{{ route('customer.login') }}">Login</a>
                        <a class="btn btn-warning text-light px-3" href="{{ route('customer.register') }}">Register</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

   
</div>
