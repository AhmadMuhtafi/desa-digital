@extends('layouts.admin')

@section('title', 'Berita')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Berita</h1>
            <p>Kelola berita dan informasi desa.</p>
        </div>

        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Tambah Berita
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

    <div class="card">
        <div class="card-head">
            <div>
                <h3>Daftar Berita</h3>
                <p>Total {{ $berita->total() }} berita tersimpan di sistem.</p>
            </div>
            <i class="bi bi-newspaper" style="font-size: 20px; color: var(--muted);"></i>
        </div>

        <div class="card-body">
            @if ($berita->isEmpty())
                {{-- Empty State --}}
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-newspaper"></i>
                    </div>
                    <h4>Belum Ada Berita</h4>
                    <p>Silakan tambahkan berita pertama untuk mulai mempublikasikan informasi desa.</p>
                    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Berita
                    </a>
                </div>
            @else
                {{-- Table --}}
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 60px;">No.</th>
                                <th style="width: 90px;">Gambar</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th style="text-align: center;">Status</th>
                                <th>Publikasi</th>
                                <th style="text-align: right; width: 120px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($berita as $item)
                                <tr>
                                    <td>{{ $berita->firstItem() + $loop->index }}</td>

                                    <td>
                                        @if ($item->gambar)
                                            <img
                                                src="{{ asset('storage/' . $item->gambar) }}"
                                                alt="{{ $item->judul }}"
                                                style="width: 64px; height: 44px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border);"
                                            >
                                        @else
                                            <div style="width: 64px; height: 44px; border-radius: 6px; background: var(--surface-2); display: grid; place-items: center; color: var(--muted); font-size: 14px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <strong>{{ $item->judul }}</strong>
                                        <small style="display: block; color: var(--muted); font-size: 12px; margin-top: 2px;">
                                            {{ $item->slug }}
                                        </small>
                                    </td>

                                    <td>
                                        @if ($item->kategori)
                                            <span class="badge tone-info">{{ $item->kategori->nama }}</span>
                                        @else
                                            <span class="muted-text">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $item->penulis?->nama_lengkap ?? '-' }}
                                    </td>

                                    <td style="text-align: center;">
                                        @php
                                            $statusMap = [
                                                'draft' => ['label' => 'Draft', 'tone' => 'tone-warning'],
                                                'published' => ['label' => 'Dipublikasikan', 'tone' => 'tone-success'],
                                                'archived' => ['label' => 'Diarsipkan', 'tone' => 'tone-info'],
                                            ];
                                            $statusInfo = $statusMap[$item->status] ?? ['label' => $item->status, 'tone' => ''];
                                        @endphp

                                        <span class="badge {{ $statusInfo['tone'] }}">
                                            {{ $statusInfo['label'] }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($item->published_at)
                                            <span class="mono" style="font-size: 12.5px;">
                                                {{ $item->published_at->format('d M Y') }}
                                                <small style="display: block; color: var(--muted);">
                                                    {{ $item->published_at->format('H:i') }} WIB
                                                </small>
                                            </span>
                                        @else
                                            <span class="muted-text">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="row-actions" style="justify-content: flex-end;">
                                            <a
                                                href="{{ route('admin.berita.edit', $item->id) }}"
                                                class="icon-btn sm edit"
                                                title="Edit berita"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form
                                                action="{{ route('admin.berita.destroy', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus berita ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="icon-btn sm danger"
                                                    title="Hapus berita"
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

                {{-- Pagination --}}
                @if ($berita->hasPages())
                    <div class="pagination" style="margin-top: 20px;">
                        {{ $berita->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection