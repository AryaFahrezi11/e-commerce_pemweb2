<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>{{ $title ?? '' }}</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
   {{ $style ?? '' }}

   <style>
      html {
         scroll-behavior: smooth;
      }
      .category-card,
      .product-card {
         transition: transform 0.3s, box-shadow 0.3s;
         height: 100%;
      }
      .category-card:hover,
      .product-card:hover {
         transform: scale(1.05);
         box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      }
      .category-img,
      .product-img {
         height: 150px;
         object-fit: cover;
         border-radius: 0.5rem 0.5rem 0 0;
      }
      .card-body {
         padding: 0.75rem;
      }
      .card-title {
         font-size: 1rem;
         font-weight: 600;
         margin-bottom: 0.5rem;
      }
      .card-text {
         font-size: 0.9rem;
         margin-bottom: 0.5rem;
         color: #555;
      }
      .btn-sm {
         font-size: 0.85rem;
         padding: 0.3rem 0.6rem;
      }
      .rating {
         color: #ffc107;
         font-size: 0.9rem;
      }
      .cart-item {
         border-bottom: 1px solid #dee2e6;
         padding: 0.75rem 0;
      }
      .cart-img {
         width: 80px;
         height: 80px;
         object-fit: cover;
         border-radius: 0.25rem;
      }
      .cart-item-name {
         font-size: 1rem;
         font-weight: 500;
      }
      .cart-item-price,
      .cart-item-subtotal {
         font-size: 0.9rem;
      }
      .quantity-input {
         width: 60px;
         font-size: 0.85rem;
         padding: 0.25rem;
      }
      .total-section {
         font-size: 1rem;
      }
      @media (max-width: 576px) {
         .cart-img {
            width: 60px;
            height: 60px;
         }
         .cart-item-name {
            font-size: 0.95rem;
         }
         .cart-item-price,
         .cart-item-subtotal {
            font-size: 0.85rem;
         }
         .quantity-input {
            width: 50px;
         }
      }

      /* Footer */
      footer {
         background: linear-gradient(135deg, #800000, #4a0000);
         color: #ffc107;
         border-top: 3px solid #ffc107; /* Garis seperti navbar */
      }
      footer h5,
      footer h6 {
         color: #ffc107;
         font-weight: 600;
      }
      footer a {
         color: #ffc107;
         text-decoration: none;
         transition: color 0.3s, text-decoration 0.3s;
      }
      footer a:hover {
         color: #fff;
         text-decoration: underline;
      }
      footer hr {
         border-top: 1px solid rgba(255, 193, 7, 0.2);
      }
   </style>
</head>
<body>

   <x-navbar themeFolder="{{ $themeFolder }}"></x-navbar>

   <main class="container-fluid py-5 mt-5">
      {{ $slot }}
   </main>

   <footer class="pt-4 mt-5">
      <div class="container p-3">
         <div class="row">
            <div class="col-md-6 mb-4">
               <h5>Irish Koff and Bakery</h5>
               <p class="small">Belanja roti dan kopi favorit Anda dengan mudah, cepat, dan aman di Irish Koff and Bakery.</p>
            </div>
            <div class="col-md-3 mb-4">
               <h6>Navigasi</h6>
               <ul class="list-unstyled">
                  <li><a href="/">Beranda</a></li>
                  <li><a href="/products">Produk</a></li>
                  <li><a href="/categories">Kategori</a></li>
                  <li><a href="/contact">Kontak</a></li>
               </ul>
            </div>
            <div class="col-md-3 mb-4">
               <h6>Kontak Kami</h6>
               <ul class="list-unstyled small">
                  <li><i class="bi bi-envelope me-1"></i> info@irishkoffbakery.com</li>
                  <li><i class="bi bi-telephone me-1"></i> +62 856 6100 994</li>
                  <li><i class="bi bi-geo-alt me-1"></i> Tegal, Indonesia</li>
               </ul>
            </div>
         </div>
         <hr>
         <div class="text-center pb-3">
            <small>© {{ date('Y') }} Irish Koff and Bakery. All rights reserved.</small>
         </div>
      </div>
   </footer>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
