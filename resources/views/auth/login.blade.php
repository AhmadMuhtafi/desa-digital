<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — {{ config('app.name', 'Laravel') }}</title>

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
    <link rel="stylesheet" href="{{ asset('assets/admin/css/auth.css') }}">
</head>
<body>
<div class="auth">

    {{-- Panel kiri (disembunyikan di layar kecil) --}}
    <aside class="auth-aside">
        <div class="auth-brand">
            <span class="brand-logo"><i class="bi bi-grid-1x2-fill"></i></span>
            <span class="brand-name">{{ config('app.name', 'Admin') }}</span>
        </div>

        <div class="auth-hero">
            <h2>Kelola bisnis Anda dengan lebih mudah.</h2>
            <p>Pantau pesanan, pelanggan, dan performa penjualan dalam satu dashboard yang rapi.</p>
            <ul class="auth-points">
                <li><i class="bi bi-bar-chart-line"></i> Statistik dan laporan real-time</li>
                <li><i class="bi bi-shield-check"></i> Akses aman khusus administrator</li>
                <li><i class="bi bi-phone"></i> Nyaman dipakai di desktop maupun ponsel</li>
            </ul>
        </div>

        <div class="auth-copy">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}</div>
    </aside>

    {{-- Panel form --}}
    <main class="auth-main">
        <button class="icon-btn auth-theme" id="themeToggle" type="button" aria-label="Ganti tema">
            <i class="bi bi-moon-stars"></i>
        </button>

        <div class="auth-card">
            <div class="mobile-brand">
                <span class="brand-logo"><i class="bi bi-grid-1x2-fill"></i></span>
                <span class="brand-name">{{ config('app.name', 'Admin') }}</span>
            </div>

            <h1>Selamat datang 👋</h1>
            <p class="lead">Masuk untuk melanjutkan ke dashboard.</p>

            @if (session('status'))
                <div class="alert alert-success" role="status">
                    <i class="bi bi-check-circle"></i><span>{{ session('status') }}</span>
                </div>
            @endif

           @if ($errors->has('username') && ! $errors->has('password'))
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>{{ $errors->first('username') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" id="loginForm" novalidate>
                @csrf

                <div class="field">
                    <label for="username">Username</label>

                    <div class="input-wrap">
                        <i class="bi bi-person lead-icon"></i>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            class="input {{ $errors->has('username') ? 'is-invalid' : '' }}"
                            placeholder="Masukkan username"
                            autocomplete="username"
                            required
                            autofocus
                        >
                    </div>

                    @error('username')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Kata sandi</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock lead-icon"></i>
                        <input type="password" id="password" name="password"
                               class="input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Masukkan kata sandi" autocomplete="current-password" required>
                        <button type="button" class="toggle-pass" id="togglePass" aria-label="Tampilkan kata sandi">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-row">
                    <label class="check">
                        <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                        Ingat saya
                    </label>
                    {{-- Aktifkan jika fitur reset kata sandi sudah dibuat --}}
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Lupa kata sandi?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
                    <span id="submitLabel">Masuk</span>
                </button>
            </form>

            <p class="auth-foot">Butuh akses? Hubungi administrator sistem.</p>
        </div>
    </main>
</div>

<script>
(function () {
    // Tampil/sembunyi kata sandi
    var pass = document.getElementById('password');
    var toggle = document.getElementById('togglePass');
    toggle.addEventListener('click', function () {
        var show = pass.type === 'password';
        pass.type = show ? 'text' : 'password';
        toggle.innerHTML = show ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        toggle.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        pass.focus();
    });

    // Ganti tema
    var root = document.documentElement;
    var themeBtn = document.getElementById('themeToggle');
    function paint() {
        themeBtn.innerHTML = root.getAttribute('data-theme') === 'dark'
            ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon-stars"></i>';
    }
    paint();
    themeBtn.addEventListener('click', function () {
        var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        root.setAttribute('data-theme', next);
        try { localStorage.setItem('admin.theme', next); } catch (e) {}
        paint();
    });

    // Status loading saat submit (mencegah klik ganda)
    var form = document.getElementById('loginForm');
    var btn = document.getElementById('submitBtn');
    form.addEventListener('submit', function () {
        if (btn.disabled) return;
        btn.disabled = true;
        document.getElementById('submitLabel').textContent = 'Memproses...';
        var s = document.createElement('span');
        s.className = 'spinner';
        btn.insertBefore(s, btn.firstChild);
    });

    // Aktifkan kembali tombol jika halaman dimuat dari cache (tombol "kembali")
    window.addEventListener('pageshow', function (e) {
        if (e.persisted) {
            btn.disabled = false;
            document.getElementById('submitLabel').textContent = 'Masuk';
            var sp = btn.querySelector('.spinner');
            if (sp) sp.remove();
        }
    });
})();
</script>
</body>
</html>