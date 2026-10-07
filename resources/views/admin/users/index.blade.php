@extends('layouts.admin')

@section('title', 'Pengguna')
@if (session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i>
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div style="padding:12px 16px; margin-bottom:20px; border-radius:8px; background:#fee2e2; color:#991b1b;">
        <i class="bi bi-exclamation-circle"></i>
        {{ session('error') }}
    </div>
@endif
@section('content')

@php
    $hasFilter = request()->filled('q') || request()->filled('role') || request()->filled('status');

    $roleTones   = ['admin' => 'tone-primary', 'manager' => 'tone-info'];
    $avatarTones = ['tone-primary', 'tone-success', 'tone-info', 'tone-warning', 'tone-danger'];

    $initials = fn ($name) => \Illuminate\Support\Str::upper(
        collect(preg_split('/\s+/', trim($name)))->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode('')
    );
@endphp

<div class="page-head">
    <div>
        <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Beranda</a><span>/</span><span>Pengguna</span></div>
        <h1>Pengguna</h1>
        <p>Kelola pengguna yang dapat mengakses panel administrasi.</p>
    </div>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Pengguna
    </a>
</div>

<div class="card">

    <div class="card-head">
        <h3>
            Daftar Pengguna
            <small>
                {{ number_format($users->total(), 0, ',', '.') }}
                {{ $hasFilter ? 'pengguna ditemukan' : 'pengguna terdaftar' }}
            </small>
        </h3>
    </div>

    {{-- Pencarian & filter (diproses di server lewat query string) --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="toolbar" role="search">
        <div class="search">
            <i class="bi bi-search"></i>
            <input type="search" name="q" value="{{ request('q') }}"
                   placeholder="Cari nama, username, atau email..." autocomplete="off">
        </div>

        @if (! empty($roles))
            <select name="role" class="select" aria-label="Filter role" onchange="this.form.submit()">
                <option value="">Semua role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role }}" @selected(request('role') === $role)>{{ ucfirst($role) }}</option>
                @endforeach
            </select>
        @endif

        <select name="status" class="select" aria-label="Filter status" onchange="this.form.submit()">
            <option value="">Semua status</option>
            <option value="1" @selected(request('status') === '1')>Aktif</option>
            <option value="0" @selected(request('status') === '0')>Nonaktif</option>
        </select>

        @if ($hasFilter)
            <a href="{{ route('admin.users.index') }}" class="reset-link">
                <i class="bi bi-x-circle"></i> Reset
            </a>
        @endif
    </form>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th style="width: 110px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            <div class="cell-user">
                                <span class="avatar {{ $avatarTones[crc32((string) $user->getKey()) % count($avatarTones)] }}">
                                    {{ $initials($user->nama_lengkap) }}
                                </span>
                                <div>
                                    <strong>
                                        {{ $user->nama_lengkap }}
                                        @if ($user->id === auth()->id())
                                            <span class="chip">Anda</span>
                                        @endif
                                    </strong>
                                    <small>{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>

                        <td><span class="mono">{{ $user->username }}</span></td>

                        <td>
                            <span class="badge {{ $roleTones[$user->role] ?? 'tone-warning' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        <td>
                            @if ($user->is_active)
                                <span class="badge tone-success">Aktif</span>
                            @else
                                <span class="badge tone-danger">Nonaktif</span>
                            @endif
                        </td>

                        <td>
                            <div class="row-actions">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="icon-btn sm edit" title="Edit" aria-label="Edit {{ $user->nama_lengkap }}">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                @if ($user->id !== auth()->id())
                                    <form method="POST"
                                          action="{{ route('admin.users.destroy', $user) }}"
                                          data-confirm-title="Hapus pengguna?"
                                          data-confirm="{{ $user->nama_lengkap }} akan dihapus dan tidak dapat dikembalikan."
                                          data-confirm-ok="Ya, hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn sm danger"
                                                title="Hapus" aria-label="Hapus {{ $user->nama_lengkap }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <div class="empty-icon"><i class="bi {{ $hasFilter ? 'bi-search' : 'bi-people' }}"></i></div>
                            @if ($hasFilter)
                                <h4>Tidak ada hasil</h4>
                                <p>Coba ubah kata kunci atau filter yang digunakan.</p>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-ghost btn-sm">Reset filter</a>
                            @else
                                <h4>Belum ada pengguna</h4>
                                <p>Tambahkan pengguna pertama untuk mulai mengelola akses.</p>
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-lg"></i> Tambah Pengguna
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->total() > 0)
        <div class="card-footer">
            <span class="muted-text">
                Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} pengguna
            </span>

            @if ($users->hasPages())
                {{ $users->withQueryString()->links('vendor.pagination.admin') }}
            @endif
        </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
    @if (session('success'))
        toast(@json(session('success')), 'bi-check-circle');
    @endif
    @if (session('error'))
        toast(@json(session('error')), 'bi-exclamation-circle');
    @endif
</script>
@endpush