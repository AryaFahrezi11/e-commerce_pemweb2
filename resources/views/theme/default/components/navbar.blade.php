<div>
    <style>
        /* Hover untuk nav-link */
        .navbar-nav .nav-link:hover {
            color: #ffc107 !important;
            background-color: rgba(255, 193, 7, 0.1);
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        /* Hover untuk brand */
        .navbar-brand:hover {
            color: #fff !important;
            transition: color 0.3s ease;
        }

        /* Hover untuk tombol Login & Register */
        .btn-outline-warning:hover {
            background-color: #ffc107 !important;
            color: #000 !important;
            border-color: #ffc107 !important;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a800 !important;
            color: #000 !important;
            transition: all 0.3s ease;
        }
    </style>

    <nav class="navbar navbar-expand-lg p-3 shadow"
        style="background: linear-gradient(135deg, #800000, #4a0000); border-bottom: 3px solid #ffc107; position: fixed; top: 0; width: 100%; z-index: 1030;">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="/" style="color: #ffc107;">
                <i class="bi bi-shop-window me-2"></i> Irish Koff and Bakery
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold text-white d-flex align-items-center" aria-current="page" href="/">
                            <i class="bi bi-house-door-fill me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-white d-flex align-items-center" href="/categories">
                            <i class="bi bi-grid-fill me-1"></i> Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-white d-flex align-items-center" href="/products">
                            <i class="bi bi-box-seam-fill me-1"></i> Produk
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <x-cart-icon></x-cart-icon>

                    @if(auth()->guard('customer')->check())
                        <div class="dropdown ms-3">
                            <a class="btn btn-outline-warning fw-semibold dropdown-toggle d-flex align-items-center" href="#"
                                role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::guard('customer')->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('customer.logout') }}">
                                        @csrf
                                        <button class="dropdown-item d-flex align-items-center" type="submit">
                                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a class="btn btn-outline-warning fw-semibold ms-3 d-flex align-items-center"
                            href="{{ route('customer.login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                        <a class="btn btn-warning fw-semibold text-dark ms-2 d-flex align-items-center"
                            href="{{ route('customer.register') }}">
                            <i class="bi bi-pencil-square me-1"></i> Register
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>
