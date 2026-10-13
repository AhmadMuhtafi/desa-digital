@extends('layouts.admin')

@section('title', 'Menu Website')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Menu Website</h1>
            <p>Kelola navigasi website desa, menu utama, dan submenu.</p>
        </div>

        <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Tambah Menu
        </a>
    </div>

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-success" role="alert" style="display: flex; align-items: flex-start; gap: 8px; padding: 12px 16px; border-radius: var(--radius-sm); background-color: var(--success-soft); color: var(--success); border: 1px solid var(--success); margin-bottom: 20px;">
            <i class="bi bi-check-circle-fill" style="font-size: 16px; margin-top: 2px;"></i>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Alert Error Session --}}
    @if (session('error'))
        <div class="alert alert-danger" role="alert" style="display: flex; align-items: flex-start; gap: 8px; padding: 12px 16px; border-radius: var(--radius-sm); background-color: var(--danger-soft); color: var(--danger); border: 1px solid var(--danger); margin-bottom: 20px;">
            <i class="bi bi-exclamation-circle-fill" style="font-size: 16px; margin-top: 2px;"></i>
            <div>
                <strong>Gagal!</strong> {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Alert Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger" role="alert" style="display: flex; align-items: flex-start; gap: 8px; padding: 12px 16px; border-radius: var(--radius-sm); background-color: var(--danger-soft); color: var(--danger); border: 1px solid var(--danger); margin-bottom: 20px;">
            <i class="bi bi-exclamation-circle-fill" style="font-size: 16px; margin-top: 2px;"></i>
            <div>
                <strong>Terjadi kesalahan.</strong>
                <ul style="margin: 4px 0 0 0; padding-left: 16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-head">
            <div>
                <h3>Daftar Menu</h3>
                <p>Total {{ $menus->count() }} menu terdaftar.</p>
            </div>
            <i class="bi bi-list-nested" style="font-size: 20px; color: var(--muted);"></i>
        </div>

        <div class="card-body">
            @if ($menus->isEmpty())
                {{-- Empty State --}}
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-menu-button-wide"></i>
                    </div>
                    <h4>Belum Ada Menu</h4>
                    <p>Tambahkan menu pertama untuk navigasi website desa.</p>
                    <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Menu
                    </a>
                </div>
            @else
                {{-- Table --}}
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Menu</th>
                                <th>URL</th>
                                <th style="text-align: center;">Urutan</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($menus as $menu)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        @if ($menu->parent_id)
                                            <div class="cell-user" style="padding-left: 16px;">
                                                <i class="bi bi-arrow-return-right" style="color: var(--muted); font-size: 14px;"></i>
                                                <div>
                                                    <strong>{{ $menu->label }}</strong>
                                                    <small>Submenu dari {{ $menu->parent?->label ?? 'Menu tidak ditemukan' }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <strong>
                                                <i class="bi bi-folder2-open" style="margin-right: 4px;"></i>
                                                {{ $menu->label }}
                                            </strong>
                                        @endif
                                    </td>

                                    <td>
                                        <code class="mono">{{ $menu->url }}</code>
                                    </td>

                                    <td style="text-align: center;">
                                        {{ $menu->urutan }}
                                    </td>

                                    <td style="text-align: center;">
                                        @if ($menu->is_active)
                                            <span class="badge tone-success">Aktif</span>
                                        @else
                                            <span class="badge tone-warning">Nonaktif</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="row-actions" style="justify-content: flex-end;">
                                            <a
                                                href="{{ route('admin.menu.edit', $menu) }}"
                                                class="icon-btn sm edit"
                                                title="Edit menu"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form
                                                action="{{ route('admin.menu.destroy', $menu) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus menu {{ addslashes($menu->label) }}?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="icon-btn sm danger"
                                                    title="Hapus menu"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection