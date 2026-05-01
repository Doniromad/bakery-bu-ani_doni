<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Toko Roti Ibu Ani')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* CSS agar menu yang aktif terlihat berbeda */
        .nav-link-custom {
            padding: 10px 15px;
            border-radius: 8px;
            transition: 0.3s;
            display: block;
            color: white;
            text-decoration: none;
        }
        .nav-link-custom:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .nav-link-custom.active {
            background: rgba(255, 255, 255, 0.2);
            font-weight: bold;
            color: white;
        }

        /* === RESPONSIVE SIDEBAR STYLE === */
        .sidebar-wrapper {
            width: 250px;
            min-height: 100vh;
            background: #8B4513;
            transition: all 0.3s ease;
            position: sticky;
            top: 0;
            z-index: 1040;
        }

        .main-wrapper {
            flex-grow: 1;
            background: #f8f9fa;
            min-height: 100vh;
            width: calc(100% - 250px);
            transition: all 0.3s ease;
        }

        .mobile-navbar {
            display: none;
            background: #8B4513;
            padding: 15px 20px;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        /* Mode Mobile (HP & Tablet kecil) */
        @media (max-width: 991px) {
            .sidebar-wrapper {
                position: fixed;
                left: -250px; /* Sembunyikan sidebar ke kiri */
                height: 100vh;
                overflow-y: auto;
            }

            .sidebar-wrapper.show {
                left: 0; /* Munculkan sidebar */
                box-shadow: 5px 0 15px rgba(0,0,0,0.3);
            }

            .main-wrapper {
                width: 100%; /* Konten penuhi layar penuh */
                padding: 15px !important;
            }

            .mobile-navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            /* Overlay hitam saat menu terbuka di HP */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1035;
            }
            .sidebar-overlay.show { display: block; }
        }
    </style>
</head>
<body>

{{-- HEADER KHUSUS MOBILE (Hanya muncul di HP) --}}
<div class="mobile-navbar">
    <h5 class="m-0 fw-bold"><i class="bi bi-shop me-2"></i> Admin Panel</h5>
    <button class="btn btn-sm text-white border-0" id="btnToggleSidebar">
        <i class="bi bi-list fs-2"></i>
    </button>
</div>

{{-- OVERLAY GELAP UNTUK MOBILE --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="d-flex">
    {{-- SIDEBAR --}}
    <nav class="sidebar-wrapper d-flex flex-column p-3 text-white shadow" id="sidebar">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold m-0 w-100 text-center d-none d-lg-block"><i class="bi bi-shop"></i> Admin Panel</h5>
            {{-- Tombol Close di dalam sidebar khusus mobile --}}
            <h5 class="fw-bold m-0 d-lg-none"><i class="bi bi-shop"></i> Menu Admin</h5>
            <button class="btn btn-sm text-white d-lg-none border-0" id="btnCloseSidebar">
                <i class="bi bi-x-lg fs-4"></i>
            </button>
        </div>
        
        <div class="flex-grow-1 overflow-auto">
            <a href="{{ route('admin.dashboard') }}" class="mb-2 nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            
            <a href="{{ route('admin.produk.index') }}" class="mb-2 nav-link-custom {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam me-2"></i> Kelola Produk
            </a>
            
            <a href="{{ route('admin.pesanan.index') }}" class="mb-2 nav-link-custom {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
                <i class="bi bi-bag me-2"></i> Kelola Pesanan
            </a>

            <a href="{{ route('admin.banner.index') }}" class="mb-2 nav-link-custom {{ request()->routeIs('admin.banner.*') ? 'active' : '' }}">
                <i class="bi bi-image me-2"></i> Kelola Banner
            </a>

            {{-- MENU BARU: Setting Bank --}}
            <a href="{{ route('admin.bank.index') }}" class="mb-2 nav-link-custom {{ request()->routeIs('admin.bank.*') ? 'active' : '' }}">
                <i class="bi bi-bank me-2"></i> Setting Bank
            </a>

            <a href="{{ route('admin.laporan') }}" class="mb-2 nav-link-custom {{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                <i class="bi bi-bar-chart me-2"></i> Laporan Penjualan
            </a>

            {{-- Profil Admin --}}
            <a href="{{ route('profile.edit') }}" class="mb-2 nav-link-custom {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="bi bi-person-circle me-2"></i> Profil Saya
            </a>
        </div>

        <hr>
        
        <form method="POST" action="{{ route('logout') }}" class="mt-auto pb-3">
            @csrf
            <button class="btn btn-outline-light btn-sm w-100 py-2 fw-bold">
                <i class="bi bi-box-arrow-left me-1"></i> Logout
            </button>
        </form>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="main-wrapper p-3 p-lg-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Konten Dinamis --}}
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Logika Javascript untuk Sidebar Mobile
    document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const btnToggle = document.getElementById('btnToggleSidebar');
        const btnClose = document.getElementById('btnCloseSidebar');

        // Fungsi membuka menu
        function openSidebar() {
            sidebar.classList.add('show');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden'; // Kunci scroll layar utama
        }

        // Fungsi menutup menu
        function closeSidebar() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = 'auto'; // Buka kembali scroll
        }

        // Trigger Tombol
        if (btnToggle) btnToggle.addEventListener('click', openSidebar);
        if (btnClose) btnClose.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);
    });
</script>
</body>
</html>