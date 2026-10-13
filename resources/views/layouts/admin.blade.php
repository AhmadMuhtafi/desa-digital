<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name', 'Laravel') }}</title>

    {{-- Terapkan tema tersimpan sebelum render agar tidak berkedip --}}
    <script>
        try {
            var t = localStorage.getItem('admin.theme');
            if (!t && window.matchMedia('(prefers-color-scheme: dark)').matches) t = 'dark';
            if (t) document.documentElement.setAttribute('data-theme', t);
        } catch (e) {}
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}">
    @stack('styles')
</head>
<body>
<div class="app" id="app">

    {{-- ===================== SIDEBAR ===================== --}}
    <aside class="sidebar" id="sidebar" aria-label="Navigasi utama">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            <span class="brand-logo"><i class="bi bi-grid-1x2-fill"></i></span>
            <span class="brand-name">{{ config('app.name', 'Admin') }}</span>
        </a>

        <nav class="nav">
            <div class="nav-label">Menu</div>

            <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            data-tip="Dashboard">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            @if (auth()->user()->role === 'admin')
                <a href="{{ route('admin.users.index') }}"
                class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                data-tip="Pengguna">
                    <i class="bi bi-person-gear"></i>
                    <span>Pengguna &amp; Peran</span>
                </a>

                <a href="{{ route('admin.menu.index') }}"
                class="nav-link {{ request()->routeIs('admin.menu.*') ? 'active' : '' }}"
                data-tip="Menu Website">
                    <i class="bi bi-list-nested"></i>
                    <span>Menu Website</span>
                </a>
            @endif

            <a
                href="{{ route('admin.kategori.index') }}"
                class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}"
                data-tip="Kategori"
            >
                <i class="bi bi-tags"></i>
                <span>Kategori</span>
            </a>

            <div class="nav-label">Pengaturan</div>
             
            <a href="{{ route('admin.profil-desa.index') }}"
            class="nav-link {{ request()->routeIs('admin.profil-desa.*') ? 'active' : '' }}"
            data-tip="Profil Desa">
                <i class="bi bi-buildings"></i>
                <span>Profil Desa</span>
            </a>

            <a href="{{ route('admin.kontak-desa.index') }}"
            class="nav-link {{ request()->routeIs('admin.kontak-desa.*') ? 'active' : '' }}"
            data-tip="Kontak Desa">
                <i class="bi bi-telephone"></i>
                <span>Kontak Desa</span>
            </a>

            <a href="{{ route('admin.pengaturan.index') }}"
                class="nav-link {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}"
                data-tip="Pengaturan">
                <i class="bi bi-gear"></i>
                <span>Pengaturan</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="upgrade-card">
                <h4>Butuh bantuan?</h4>
                <p>Lihat dokumentasi atau hubungi tim support.</p>
                <a href="#" class="btn btn-sm">Buka dokumentasi</a>
            </div>
        </div>
    </aside>
    <div class="overlay" id="overlay"></div>

    {{-- ===================== MAIN ===================== --}}
    <div class="main">
        <header class="topbar">
            <button class="icon-btn" id="sidebarToggle" type="button" aria-label="Buka/tutup sidebar">
                <i class="bi bi-list"></i>
            </button>

            <form class="search" role="search" action="#" onsubmit="return false">
                <i class="bi bi-search"></i>
                <input type="search" id="globalSearch" placeholder="Cari sesuatu..." autocomplete="off">
                <kbd>/</kbd>
            </form>

            <div class="topbar-actions">
                <button class="icon-btn" id="searchToggle" type="button" aria-label="Cari">
                    <i class="bi bi-search"></i>
                </button>

                <button class="icon-btn" id="themeToggle" type="button" aria-label="Ganti tema">
                    <i class="bi bi-moon-stars"></i>
                </button>

                {{-- Notifikasi --}}
                <div class="dropdown">
                    <button class="icon-btn" type="button" data-dropdown aria-label="Notifikasi">
                        <i class="bi bi-bell"></i><span class="dot"></span>
                    </button>
                    <div class="dropdown-menu notif-menu">
                        <div class="dropdown-head">
                            <strong>Notifikasi</strong>
                            <span class="badge tone-primary">3 baru</span>
                        </div>
                        <a href="#" class="notif-item">
                            <span class="notif-icon tone-success"><i class="bi bi-bag-check"></i></span>
                            <div><p>Pesanan <strong>#INV-2041</strong> telah dibayar.</p><small>5 menit lalu</small></div>
                        </a>
                        <a href="#" class="notif-item">
                            <span class="notif-icon tone-warning"><i class="bi bi-exclamation-triangle"></i></span>
                            <div><p>Stok <strong>Sepatu Runner</strong> tersisa 3 unit.</p><small>1 jam lalu</small></div>
                        </a>
                        <a href="#" class="notif-item">
                            <span class="notif-icon tone-info"><i class="bi bi-person-plus"></i></span>
                            <div><p>Pelanggan baru mendaftar.</p><small>3 jam lalu</small></div>
                        </a>
                        <div class="notif-foot"><a href="#">Lihat semua notifikasi</a></div>
                    </div>
                </div>

                {{-- Menu pengguna --}}
                <div class="dropdown">
                    <button class="user-btn" type="button" data-dropdown>
                        <span class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}</span>
                        <span class="user-meta">
                            <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
                            <small>Administrator</small>
                        </span>
                        <i class="bi bi-chevron-down" style="font-size:12px;color:var(--muted)"></i>
                    </button>
                    <div class="dropdown-menu">
                        <div class="dropdown-head">
                            <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
                            <small>{{ auth()->user()->email ?? 'admin@example.com' }}</small>
                        </div>
                        <a href="#" class="dropdown-item"><i class="bi bi-person"></i> Profil saya</a>
                        <a href="#" class="dropdown-item"><i class="bi bi-gear"></i> Pengaturan</a>
                        <div class="dropdown-divider"></div>
                        {{-- Pastikan route logout ada (Breeze/Jetstream/UI) --}}
                        <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}">
                            @csrf
                            <button type="submit" class="dropdown-item danger"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="content">
            @yield('content')
        </main>

        <footer class="footer">
            <span>&copy; {{ date('Y') }} {{ config('app.name', 'WebDesKu') }}. Semua hak dilindungi.</span>
            <span>WebDesKu v{{ Illuminate\Foundation\Application::VERSION }}</span>
        </footer>
    </div>
</div>

<script src="{{ asset('assets/admin/js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
