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
            padding: 12px 15px;
            border-radius: 10px;
            transition: 0.3s;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        .nav-link-custom i {
            font-size: 1.1rem;
        }
        .nav-link-custom:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .nav-link-custom.active {
            background: rgba(255, 255, 255, 0.2);
            font-weight: bold;
            color: white;
            box-shadow: inset 4px 0 0 white; /* Garis indikator kiri */
        }

        /* === RESPONSIVE SIDEBAR STYLE === */
        .sidebar-wrapper {
            width: 260px;
            min-height: 100vh;
            background: #8B4513; /* Warna Cokelat Bakery */
            transition: all 0.3s ease;
            position: sticky;
            top: 0;
            z-index: 1040;
        }

        .main-wrapper {
            flex-grow: 1;
            background: #F8FAFC;
            min-height: 100vh;
            width: calc(100% - 260px);
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
                left: -260px;
                height: 100vh;
                overflow-y: auto;
            }

            .sidebar-wrapper.show {
                left: 0;
                box-shadow: 5px 0 15px rgba(0,0,0,0.3);
            }

            .main-wrapper {
                width: 100%;
                padding: 10px !important;
            }

            .mobile-navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1035;
            }
            .sidebar-overlay.show { display: block; }
        }
    </style>
</head>
<body>

{{-- HEADER KHUSUS MOBILE --}}
<div class="mobile-navbar">
    <h5 class="m-0 fw-bold text-uppercase" style="letter-spacing: 1px;"><i class="bi bi-person-badge me-2"></i> Admin Panel</h5>
    <button class="btn btn-sm text-white border-0" id="btnToggleSidebar">
        <i class="bi bi-list fs-1"></i>
    </button>
</div>

{{-- OVERLAY GELAP UNTUK MOBILE --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="d-flex">
    {{-- SIDEBAR --}}
    <nav class="sidebar-wrapper d-flex flex-column p-3 text-white shadow" id="sidebar">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <h5 class="fw-bold m-0 w-100 text-center d-none d-lg-block"><i class="bi bi-shop me-2"></i> ADMIN PANEL</h5>
            <h5 class="fw-bold m-0 d-lg-none"><i class="bi bi-list-task me-2"></i> MENU ADMIN</h5>
            <button class="btn btn-sm text-white d-lg-none border-0" id="btnCloseSidebar">
                <i class="bi bi-x-lg fs-4"></i>
            </button>
        </div>
        
        <div class="flex-grow-1 overflow-auto">
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-3"></i> Dashboard
            </a>
            
            {{-- Kelola Produk (Aktif jika di rute produk ATAU kategori) --}}
            <a href="{{ route('admin.produk.index') }}" class="nav-link-custom {{ request()->routeIs('admin.produk.*') || request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam me-3"></i> Kelola Produk
            </a>
            
            {{-- Kelola Pesanan --}}
            <a href="{{ route('admin.pesanan.index') }}" class="nav-link-custom {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
                <i class="bi bi-bag-check me-3"></i> Kelola Pesanan
            </a>

            {{-- Kelola Banner --}}
            <a href="{{ route('admin.banner.index') }}" class="nav-link-custom {{ request()->routeIs('admin.banner.*') ? 'active' : '' }}">
                <i class="bi bi-image me-3"></i> Kelola Banner
            </a>

            {{-- Setting Bank --}}
            <a href="{{ route('admin.bank.index') }}" class="nav-link-custom {{ request()->routeIs('admin.bank.*') ? 'active' : '' }}">
                <i class="bi bi-bank me-3"></i> Setting Bank
            </a>

            {{-- Laporan Penjualan --}}
            <a href="{{ route('admin.laporan') }}" class="nav-link-custom {{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line me-3"></i> Laporan Penjualan
            </a>

            {{-- Profil Admin --}}
            <a href="{{ route('profile.edit') }}" class="nav-link-custom {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="bi bi-person-circle me-3"></i> Profil Saya
            </a>
        </div>

        {{-- PERBAIKAN TOMBOL LOGOUT --}}
        <div class="pt-3 border-top border-white border-opacity-10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link-custom w-100 text-start border-0 bg-transparent">
                    <i class="bi bi-box-arrow-left me-3"></i> Logout Akun
                </button>
            </form>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="main-wrapper p-3 p-lg-4">
        {{-- Flash Message Success --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                    <div>
                        <strong class="d-block">Berhasil!</strong>
                        <span class="small">{{ session('success') }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Flash Message Error --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                    <div>
                        <strong class="d-block">Gagal!</strong>
                        <span class="small">{{ session('error') }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Konten Dinamis --}}
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Logika Sidebar Mobile
    document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const btnToggle = document.getElementById('btnToggleSidebar');
        const btnClose = document.getElementById('btnCloseSidebar');

        function openSidebar() {
            sidebar.classList.add('show');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        if (btnToggle) btnToggle.addEventListener('click', openSidebar);
        if (btnClose) btnClose.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);
    });
</script>
</body>
</html>