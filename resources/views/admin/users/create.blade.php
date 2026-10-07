@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')

<div class="page-head">
    <div>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Beranda</a>
            <span>/</span>
            <a href="{{ route('admin.users.index') }}">Pengguna</a>
            <span>/</span>
            <span>Tambah</span>
        </div>
        <h1>Tambah Pengguna</h1>
        <p>Tambahkan pengguna baru yang dapat mengakses panel administrasi.</p>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf

    <div class="card">
        <div class="card-head">
            <div>
                <h3>Informasi Pengguna</h3>
                <small>Lengkapi data pengguna di bawah ini.</small>
            </div>
        </div>

        <div class="card-body">
            <div class="form-grid">

                {{-- Nama Lengkap --}}
                <div class="field">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input
                        type="text"
                        id="nama_lengkap"
                        name="nama_lengkap"
                        value="{{ old('nama_lengkap') }}"
                        class="input @error('nama_lengkap') is-invalid @enderror"
                        placeholder="Masukkan nama lengkap"
                        required
                    >
                    @error('nama_lengkap')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Username --}}
                <div class="field">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        class="input @error('username') is-invalid @enderror"
                        placeholder="Masukkan username"
                        autocomplete="username"
                        required
                    >
                    @error('username')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="field">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="input @error('email') is-invalid @enderror"
                        placeholder="contoh@email.com"
                        required
                    >
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Role --}}
                <div class="field">
                    <label for="role">Role</label>
                    <select
                        id="role"
                        name="role"
                        class="input @error('role') is-invalid @enderror"
                        required
                    >
                        <option value="">Pilih Role</option>
                        <option value="admin"    @selected(old('role') === 'admin')>Admin</option>
                        <option value="editor"   @selected(old('role') === 'editor')>Editor</option>
                        <option value="operator" @selected(old('role') === 'operator')>Operator</option>
                    </select>
                    @error('role')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="field">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="input @error('password') is-invalid @enderror"
                        placeholder="Masukkan password"
                        autocomplete="new-password"
                        required
                    >
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="field">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="input"
                        placeholder="Ulangi password"
                        autocomplete="new-password"
                        required
                    >
                </div>

            </div>

            {{-- Status --}}
            <div class="field" style="margin-top:18px;">
                <label for="is_active">Status</label>
                <select id="is_active" name="is_active" class="input" required>
                    <option value="1" @selected(old('is_active', '1') == '1')>Aktif</option>
                    <option value="0" @selected(old('is_active') === '0')>Nonaktif</option>
                </select>
                @error('is_active')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Simpan Pengguna
            </button>
        </div>
    </div>
</form>

@endsection