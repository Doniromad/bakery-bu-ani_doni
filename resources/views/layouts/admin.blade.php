<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Toko Roti Ibu Ani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* CSS agar menu yang aktif terlihat berbeda */
        .nav-link-custom {
            padding: 10px 15px;
            border-radius: 8px;
            transition: 0.3s;
            display: block;
        }
        .nav-link-custom:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .nav-link-custom.active {
            background: rgba(255, 255, 255, 0.2);
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <nav class="d-flex flex-column p-3 text-white" style="width:230px; min-height:100vh; background:#8B4513;">
        <h5 class="mb-4 fw-bold text-center"><i class="bi bi-shop"></i> Admin Panel</h5>
        
        <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none mb-2 nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        
        <a href="{{ route('admin.produk.index') }}" class="text-white text-decoration-none mb-2 nav-link-custom {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam me-2"></i> Kelola Produk
        </a>
        
        <a href="{{ route('admin.pesanan.index') }}" class="text-white text-decoration-none mb-2 nav-link-custom {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
            <i class="bi bi-bag me-2"></i> Kelola Pesanan
        </a>

        <a href="{{ route('admin.banner.index') }}" class="text-white text-decoration-none mb-2 nav-link-custom {{ request()->routeIs('admin.banner.*') ? 'active' : '' }}">
            <i class="bi bi-image me-2"></i> Kelola Banner
        </a>

        {{-- MENU BARU: Setting Bank --}}
        <a href="{{ route('admin.bank.index') }}" class="text-white text-decoration-none mb-2 nav-link-custom {{ request()->routeIs('admin.bank.*') ? 'active' : '' }}">
            <i class="bi bi-bank me-2"></i> Setting Bank
        </a>

        <a href="{{ route('admin.laporan') }}" class="text-white text-decoration-none mb-2 nav-link-custom {{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
            <i class="bi bi-bar-chart me-2"></i> Laporan Penjualan
        </a>

        {{-- Profil Admin --}}
        <a href="{{ route('profile.edit') }}" class="text-white text-decoration-none mb-2 nav-link-custom {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="bi bi-person-circle me-2"></i> Profil Saya
        </a>

        <hr>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-light btn-sm w-100">
                <i class="bi bi-box-arrow-left me-1"></i> Logout
            </button>
        </form>
    </nav>

    <main class="flex-grow-1 p-4" style="background:#f8f9fa;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>