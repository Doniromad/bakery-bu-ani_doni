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

        /* 1. SMOOTH SCROLL */
        html {
            scroll-behavior: smooth;
        }

        body { 
            font-family: 'DM Sans', sans-serif; 
            background-color: var(--soft-blue); 
            color: var(--slate-dark); 
            padding-top: 85px; 
        }

        /* 2. OFFSET SCROLL UNTUK ANCHOR */
        #produk {
            scroll-margin-top: 110px;
        }

        /* NAVBAR STYLE */
        .navbar-custom { 
            background: rgba(255, 255, 255, 0.98); 
            border-bottom: 2px solid var(--primary-blue); 
            height: 85px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            color: var(--primary-blue) !important;
            font-size: 1.2rem;
            letter-spacing: 1px;
        }

        .nav-link { 
            color: var(--slate-dark) !important; 
            font-weight: 600; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 1.5px;
            padding: 10px 20px !important;
            transition: 0.3s;
            position: relative;
        }

        .nav-link:hover, .nav-link.active { 
            color: var(--primary-blue) !important; 
        }

        /* Garis Bawah Navigasi */
        .nav-link.active::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 20px;
            right: 20px;
            height: 2px;
            background-color: var(--primary-blue);
        }

        /* HERO BANNER STYLING */
        .hero-banner-container {
            height: 400px;
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .hero-banner-container::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(30, 41, 59, 0.5); 
            z-index: 1;
        }

        .hero-text-overlay {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 0 20px;
        }

        .hero-text-overlay h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
        }

        .hero-text-overlay p {
            letter-spacing: 2px;
            opacity: 0.9;
        }

        .search-box { position: relative; width: 180px; }
        .search-box input { 
            border-radius: 50px; 
            border: 1px solid #ddd; 
            padding: 6px 10px 6px 35px; 
            font-size: 0.75rem; 
            width: 100%; 
            background: #f8f9fa;
            outline: none;
        }
        .search-box input:focus { border-color: var(--primary-blue); background: white; }
        .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--primary-blue); }

        .btn-login { color: var(--slate-dark); text-decoration: none; font-size: 0.8rem; font-weight: 700; transition: 0.2s; }
        .btn-login:hover { color: var(--primary-blue); }

        .btn-daftar { 
            background: var(--gold-accent); 
            color: var(--slate-dark); 
            padding: 8px 20px; 
            border-radius: 50px; 
            font-weight: 700; 
            text-decoration: none; 
            font-size: 0.8rem; 
            box-shadow: 0 4px 10px rgba(255, 215, 0, 0.2);
            transition: 0.2s;
        }
        .btn-daftar:hover { background: #ffea00; transform: translateY(-1px); }

        .cart-icon { font-size: 1.3rem; color: var(--primary-blue); margin-left: 15px; }

        footer { background: var(--white); border-top: 1px solid #eee; padding: 40px 0; color: #666; font-size: 0.85rem; margin-top: 50px; }
        .footer-brand { font-family: 'Playfair Display', serif; color: var(--slate-dark); }
    </style>
</head>
<body data-bs-spy="scroll" data-bs-target="#navbarNav" data-bs-offset="120">

<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">TOKO ROTI IBU ANI</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') && !request()->has('search') ? 'active' : '' }}" 
                       id="nav-beranda" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->has('search') ? 'active' : '' }}" id="nav-produk" href="{{ route('home') }}#produk">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pelanggan.riwayat') ? 'active' : '' }}" href="{{ route('pelanggan.riwayat') }}">Pesanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">Profil</a>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <form action="{{ route('home') }}" method="GET" class="search-box d-none d-xl-block">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" placeholder="CARI ROTI..." value="{{ request('search') }}">
                </form>

                @auth
                    <a href="{{ route('pelanggan.keranjang') }}" class="cart-icon"><i class="bi bi-cart3"></i></a>
                    <div class="dropdown ms-3">
                        <button class="btn btn-sm btn-outline-primary dropdown-toggle rounded-pill px-3 fw-bold" type="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2">
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i>Profil Saya
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger py-2">
                                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="ms-3 d-flex align-items-center">
                        <a href="{{ route('login') }}" class="btn-login me-4">MASUK</a>
                        <a href="{{ route('register') }}" class="btn-daftar shadow-sm">DAFTAR</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Konten Utama --}}
<main class="container">
    @yield('content')
</main>

<footer>
    <div class="container text-center">
        <h6 class="footer-brand fw-bold mb-2">TOKO ROTI IBU ANI</h6>
        <p class="mb-0 text-muted">© 2026 TOKO ROTI IBU ANI. ALL RIGHTS RESERVED.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navBeranda = document.getElementById('nav-beranda');
        const navProduk = document.getElementById('nav-produk');

        // LOGIKA AUTO SCROLL SAAT SEARCH
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('search')) {
            const produkSection = document.getElementById('produk');
            if (produkSection) {
                setTimeout(() => {
                    produkSection.scrollIntoView({ behavior: 'smooth' });
                }, 300);
            }
        }

        function clearActive() {
            document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
                link.classList.remove('active');
            });
        }

        if (navProduk) {
            navProduk.addEventListener('click', function() {
                clearActive();
                this.classList.add('active');
            });
        }

        if (navBeranda) {
            navBeranda.addEventListener('click', function() {
                if (window.location.pathname === '/') {
                    clearActive();
                    this.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', function() {
            const produkSection = document.getElementById('produk');
            if (produkSection && window.location.pathname === '/') {
                const rect = produkSection.getBoundingClientRect();
                if (rect.top <= 150) {
                    clearActive();
                    if (navProduk) navProduk.classList.add('active');
                } else {
                    if (!urlParams.has('search')) {
                        clearActive();
                        if (navBeranda) navBeranda.classList.add('active');
                    }
                }
            }
        });
    });
</script>

</body>
</html>