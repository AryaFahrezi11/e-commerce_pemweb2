<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>{{ $title ?? 'Irish Koff and Bakery' }}</title>

   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <!-- Bootstrap Icons -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

   {{ $style ?? '' }}

   <style>
      .category-card, .product-card {
         transition: transform 0.3s;
         height: 100%;
      }
      .category-card:hover, .product-card:hover {
         transform: scale(1.05);
         box-shadow: 0 3px 6px rgba(0,0,0,0.15);
      }
      .category-img, .product-img {
         height: 120px;
         object-fit: cover;
      }
      .card-body {
         padding: 0.75rem;
      }
      .card-title {
         font-size: 1rem;
         margin-bottom: 0.5rem;
      }
      .card-text {
         font-size: 0.85rem;
         margin-bottom: 0.5rem;
      }
      .btn-sm {
         font-size: 0.8rem;
         padding: 0.25rem 0.5rem;
      }
      .rating {
         color: #ffc107;
         font-size: 0.85rem;
      }
      .cart-item {
         border-bottom: 1px solid #dee2e6;
         padding: 0.75rem 0;
      }
      .cart-img {
         width: 80px;
         height: 80px;
         object-fit: cover;
      }
      .cart-item-name {
         font-size: 1rem;
         font-weight: 500;
      }
      .cart-item-price, .cart-item-subtotal {
         font-size: 0.85rem;
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
            font-size: 0.9rem;
         }
         .cart-item-price, .cart-item-subtotal {
            font-size: 0.8rem;
         }
         .quantity-input {
            width: 50px;
         }
      }
   </style>
</head>
<body class="d-flex flex-column min-vh-100">

   <x-navbar themeFolder="{{ $themeFolder }}" />

   <!-- Konten utama -->
   <main class="container-fluid py-4 flex-grow-1">
      {{ $slot }}
   </main>

   <!-- Footer -->
   <footer class="text-white pt-4 mt-5" style="background: linear-gradient(135deg, rgba(17, 17, 17, 0.9) 0%, rgba(139, 0, 0, 0.9) 100%);">
      <div class="container p-3">
         <div class="row">
            <div class="col-md-6 mb-3">
               <h5 class="mb-3 fw-bold">Irish Koff and Bakery</h5>
               <p class="small">
                  Nikmati pengalaman belanja yang mudah, cepat, dan aman di website resmi Irish Koff and Bakery. Kami menyediakan berbagai menu makanan dan minuman pilihan dengan kualitas terbaik dan harga terjangkau.
               </p>
            </div>
            <div class="col-md-3 mb-3">
               <h6 class="mb-3 fw-bold">Navigasi</h6>
               <ul class="list-unstyled">
                  <li><a href="/" class="text-white text-decoration-none">Beranda</a></li>
                  <li><a href="/products" class="text-white text-decoration-none">Produk</a></li>
                  <li><a href="/categories" class="text-white text-decoration-none">Kategori</a></li>
                  <li><a href="/contact" class="text-white text-decoration-none">Kontak</a></li>
               </ul>
            </div>
            <div class="col-md-3 mb-3">
               <h6 class="mb-3 fw-bold">Kontak Kami</h6>
               <ul class="list-unstyled small mb-2">
                  <li><i class="bi bi-envelope me-2"></i> info@irishkoffbakery.com</li>
                  <li><i class="bi bi-telephone me-2"></i> +62 856 6100 994</li>
                  <li><i class="bi bi-geo-alt me-2"></i> Jl. Mawar No.123, Tegal, Indonesia</li>
               </ul>
               <div class="d-flex gap-3 mt-2">
                  <a href="https://www.instagram.com/irishkoffbakery" target="_blank" class="text-white fs-5" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                  <a href="https://www.facebook.com/irishkoffbakery" target="_blank" class="text-white fs-5" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                  <a href="https://wa.me/628566100994" target="_blank" class="text-white fs-5" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                  <a href="https://www.tiktok.com/@irishkoffbakery" target="_blank" class="text-white fs-5" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
               </div>
            </div>
         </div>
         <hr class="bg-secondary">
         <div class="text-center pb-3">
            <small>© {{ date('Y') }} Irish Koff and Bakery. All rights reserved.</small>
         </div>
      </div>
   </footer>

</body>

</html>
