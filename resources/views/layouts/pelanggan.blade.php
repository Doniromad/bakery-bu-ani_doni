<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Roti Ibu Ani')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #4A90E2;
            --dark-blue: #357ABD;
            --soft-blue: #F0F7FF;
            --slate-dark: #1E293B;
            --white: #FFFFFF;
            --gold-accent: #FFD700;
        }

        body { 
            font-family: 'DM Sans', sans-serif; 
            background-color: var(--soft-blue); 
            color: var(--slate-dark); 
            padding-top: 85px; 
            overflow-x: hidden;
        }

        /* === NAVBAR STYLE UPDATED === */
        .navbar-custom { 
            background: #ffffff !important; /* Dibuat solid putih agar tidak transparan */
            border-bottom: 2px solid var(--primary-blue); 
            min-height: 85px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            z-index: 1100;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            color: var(--primary-blue) !important;
            font-size: 1.1rem;
            letter-spacing: 1px;
        }

        .nav-link { 
            color: var(--slate-dark) !important; 
            font-weight: 600; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 1.2px;
            padding: 10px 18px !important;
            transition: 0.3s;
            position: relative;
        }

        .nav-link:hover, .nav-link.active { 
            color: var(--primary-blue) !important; 
        }

        /* Garis Bawah Navigasi Desktop */
        @media (min-width: 992px) {
            .nav-link.active::after {
                content: "";
                position: absolute;
                bottom: 0;
                left: 18px;
                right: 18px;
                height: 3px;
                background-color: var(--primary-blue);
                border-radius: 50px 50px 0 0;
            }
        }

        /* === PERBAIKAN KHUSUS MOBILE === */
        @media (max-width: 991px) {
            .navbar-custom { height: auto; padding: 10px 0; }
            
            .navbar-collapse {
                background: #ffffff; /* Latar belakang menu dropdown solid putih */
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                padding: 1.5rem;
                box-shadow: 0 15px 25px rgba(0,0,0,0.1);
                border-top: 1px solid #eee;
                max-height: 80vh;
                overflow-y: auto;
            }

            .navbar-nav { padding-bottom: 15px; }

            .nav-item {
                border-bottom: 1px solid #f8f9fa;
                margin-bottom: 5px;
            }

            .nav-link {
                padding: 12px 10px !important;
                font-size: 0.85rem;
            }

            .nav-link.active {
                background: var(--soft-blue);
                color: var(--primary-blue) !important;
                border-radius: 8px;
            }

            .search-box-mobile {
                margin-top: 15px;
                width: 100% !important;
            }
        }

        .search-box { position: relative; width: 180px; }
        .search-box input { 
            border-radius: 50px; 
            border: 1px solid #ddd; 
            padding: 8px 10px 8px 35px; 
            font-size: 0.75rem; 
            width: 100%; 
            background: #f8f9fa;
            outline: none;
        }
        .search-box input:focus { border-color: var(--primary-blue); background: white; }
        .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--primary-blue); }

        .btn-login { color: var(--slate-dark); text-decoration: none; font-size: 0.8rem; font-weight: 700; }
        .btn-daftar { 
            background: var(--gold-accent); 
            color: var(--slate-dark); 
            padding: 8px 22px; 
            border-radius: 50px; 
            font-weight: 700; 
            text-decoration: none; 
            font-size: 0.8rem; 
            transition: 0.2s;
        }
        .btn-daftar:hover { background: #ffea00; transform: translateY(-1px); }

        .cart-icon { font-size: 1.4rem; color: var(--primary-blue); position: relative; }

        footer { background: var(--white); border-top: 1px solid #eee; padding: 40px 0; color: #666; font-size: 0.85rem; margin-top: 50px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <div style="width: 40px; height: 40px; background: white; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: 1px solid #eee;" class="me-2">
                <img src="{{ asset('images/logo-toko.png') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <span class="fw-bold text-primary text-uppercase" style="letter-spacing: 1.5px; font-size: 1.1rem; font-family: 'Playfair Display', serif;">
                Bakery Bu Ani
            </span>
        </a>
        
        <!-- Hamburger Menu -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links & Search -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pelanggan.produk.index') || request()->routeIs('pelanggan.kategori') ? 'active' : '' }}" href="{{ route('pelanggan.produk.index') }}">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pelanggan.riwayat') ? 'active' : '' }}" href="{{ route('pelanggan.riwayat') }}">Pesanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">Profil</a>
                </li>
            </ul>

            <div class="d-flex align-items-center flex-wrap gap-2">
                <!-- Search Box (Hidden on Mobile, visible in collapse) -->
                <form action="{{ route('pelanggan.produk.index') }}" method="GET" class="search-box ms-lg-3 search-box-mobile">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" placeholder="CARI ROTI..." value="{{ request('search') }}">
                </form>

                @auth
                    <div class="d-flex align-items-center ms-lg-3">
                        <a href="{{ route('pelanggan.keranjang') }}" class="cart-icon me-3">
                            <i class="bi bi-cart3"></i>
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle rounded-pill px-3 fw-bold" type="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2">
                                <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item text-danger py-2 w-100 text-start border-0 bg-transparent">
                                            <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="ms-lg-3 d-flex align-items-center gap-3">
                        <a href="{{ route('login') }}" class="btn-login">MASUK</a>
                        <a href="{{ route('register') }}" class="btn-daftar shadow-sm">DAFTAR</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main class="container">
    @yield('content')
</main>

<footer class="mt-4 mt-md-5 pt-4 pt-md-5 pb-3 bg-white border-top">
    <div class="container">
        <div class="row g-4 g-md-5">
            <!-- Informasi Toko -->
            <div class="col-12 col-lg-4 pe-lg-4">
                <h5 class="fw-bold text-primary mb-3" style="font-family: 'Playfair Display', serif;">Bakery Bu Ani</h5>
                <p class="text-muted small mb-4" style="line-height: 1.8;">
                    Menyajikan kehangatan dan kelembutan roti autentik sejak tahun 2026. Kami berkomitmen memberikan kualitas terbaik dengan bahan-bahan pilihan setiap harinya.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-circle footer-social-btn"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-circle footer-social-btn"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-circle footer-social-btn"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            <!-- Navigasi (Mendapat 50% layar di HP) -->
            <div class="col-6 col-md-3 col-lg-2 ms-lg-auto">
                <h6 class="fw-bold text-dark mb-3">Navigasi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none text-muted footer-link">Beranda</a></li>
                    <li class="mb-2"><a href="{{ route('pelanggan.produk.index') }}" class="text-decoration-none text-muted footer-link">Produk</a></li>
                    <li class="mb-2"><a href="{{ route('pelanggan.riwayat') }}" class="text-decoration-none text-muted footer-link">Pesanan</a></li>
                </ul>
            </div>

            <!-- Kontak (100% di layar HP sangat kecil agar teks alamat tidak terpotong) -->
            <div class="col-12 col-sm-6 col-md-5 col-lg-3">
                <h6 class="fw-bold text-dark mb-3">Hubungi Kami</h6>
                <ul class="list-unstyled small text-muted">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-geo-alt text-primary me-2 mt-1"></i>
                        <span style="line-height: 1.5;">Jl. Bakery No. 12, Kota Roti, Indonesia</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center">
                        <i class="bi bi-telephone text-primary me-2"></i>
                        <span>+62 812-3456-7890</span>
                    </li>
                </ul>
            </div>

            <!-- Jam Operasional (Mendapat 50% layar di HP berdampingan dengan Navigasi/Kontak) -->
            <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                <h6 class="fw-bold text-dark mb-3">Jam Buka</h6>
                <p class="text-muted small mb-1">Senin - Sabtu</p>
                <p class="fw-bold text-dark small mb-3">07:00 - 20:00</p>
                <p class="text-muted small mb-1">Minggu</p>
                <p class="fw-bold text-dark small mb-0">08:00 - 17:00</p>
            </div>
        </div>

        <hr class="my-4 opacity-10">
        
        <div class="text-center">
            <p class="mb-0 text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                &copy; 2026 <strong>Bakery Bu Ani</strong>. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>

<style>
    /* Transisi tautan agar lebih elegan saat disentuh/di-hover */
    .footer-link {
        transition: all 0.3s ease;
        display: inline-block;
    }
    .footer-link:hover {
        color: var(--primary-blue, #4A90E2) !important;
        transform: translateX(5px);
        font-weight: 600;
    }

    /* Tombol sosial media membulat sempurna */
    .footer-social-btn {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    .footer-social-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(74, 144, 226, 0.2);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>