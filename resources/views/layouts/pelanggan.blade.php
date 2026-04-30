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
<body>

<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <div style="width: 40px; height: 40px; background: white; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: 1px solid #eee;" class="me-2">
                <img src="{{ asset('images/logo-toko.png') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <span class="fw-bold text-primary text-uppercase" style="letter-spacing: 1.5px; font-size: 1.15rem; font-family: 'Playfair Display', serif;">
                Bakery Bu Ani
            </span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    {{-- Navigasi langsung ke halaman produk --}}
                    <a class="nav-link {{ request()->routeIs('pelanggan.produk.index') || request()->routeIs('pelanggan.kategori') ? 'active' : '' }}" href="{{ route('pelanggan.produk.index') }}">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pelanggan.riwayat') ? 'active' : '' }}" href="{{ route('pelanggan.riwayat') }}">Pesanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">Profil</a>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                {{-- Form pencarian diarahkan ke halaman produk --}}
                <form action="{{ route('pelanggan.produk.index') }}" method="GET" class="search-box d-none d-xl-block">
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

<main class="container">
    @yield('content')
</main>

<footer class="mt-5 pt-5 pb-3 bg-white border-top">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="fw-bold text-primary mb-3" style="font-family: 'Playfair Display', serif;">Bakery Bu Ani</h5>
                <p class="text-muted small mb-4" style="line-height: 1.8;">
                    Menyajikan kehangatan dan kelembutan roti autentik sejak tahun 2026. Kami berkomitmen memberikan kualitas terbaik dengan bahan-bahan pilihan setiap harinya.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            <div class="col-6 col-lg-2 ms-lg-auto">
                <h6 class="fw-bold text-dark mb-3">Navigasi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Beranda</a></li>
                    {{-- Footer juga diarahkan ke halaman produk --}}
                    <li class="mb-2"><a href="{{ route('pelanggan.produk.index') }}" class="text-decoration-none text-muted">Produk</a></li>
                    <li class="mb-2"><a href="{{ route('pelanggan.riwayat') }}" class="text-decoration-none text-muted">Pesanan</a></li>
                    <li class="mb-2"><a href="{{ route('profile.edit') }}" class="text-decoration-none text-muted">Profil</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-3">
                <h6 class="fw-bold text-dark mb-3">Hubungi Kami</h6>
                <ul class="list-unstyled small text-muted">
                    <li class="mb-2 d-flex align-items-start">
                        <i class="bi bi-geo-alt text-primary me-2 mt-1"></i>
                        <span>Jl. Bakery No. 12, Kota Roti, Indonesia</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center">
                        <i class="bi bi-telephone text-primary me-2"></i>
                        <span>+62 812-3456-7890</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center">
                        <i class="bi bi-envelope text-primary me-2"></i>
                        <span>halo@bakerybuani.com</span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-2">
                <h6 class="fw-bold text-dark mb-3">Jam Buka</h6>
                <p class="text-muted small mb-1">Senin - Sabtu</p>
                <p class="fw-bold text-dark small mb-3">07:00 - 20:00</p>
                <p class="text-muted small mb-1">Minggu</p>
                <p class="fw-bold text-dark small">08:00 - 17:00</p>
            </div>
        </div>

        <hr class="my-4 opacity-50">
        
        <div class="text-center">
            <p class="mb-0 text-muted small">
                &copy; 2026 <strong>Bakery Bu Ani</strong>. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>