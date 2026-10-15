@extends('layouts.admin')

@section('title', 'Galeri Album')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Galeri Album</h1>
            <p>Kelola album foto website desa.</p>
        </div>

        <a href="{{ route('admin.galeri-album.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Tambah Album
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
                <h3>Daftar Album</h3>
                <p>Total {{ $album->total() }} album tersimpan di sistem.</p>
            </div>
            <i class="bi bi-images" style="font-size: 20px; color: var(--muted);"></i>
        </div>

        <div class="card-body">
            @if ($album->isEmpty())
                {{-- Empty State --}}
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-images"></i>
                    </div>
                    <h4>Belum Ada Album</h4>
                    <p>Silakan tambahkan album pertama untuk mulai mengelola galeri foto desa.</p>
                    <a href="{{ route('admin.galeri-album.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Album
                    </a>
                </div>
            @else
                {{-- Table --}}
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 60px;">No.</th>
                                <th style="width: 100px;">Cover</th>
                                <th>Judul Album</th>
                                <th>Deskripsi</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: right; width: 120px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($album as $item)
                                <tr>
                                    <td>{{ $album->firstItem() + $loop->index }}</td>

                                    <td>
                                        @if ($item->cover)
                                            <a
                                                href="{{ asset('storage/' . $item->cover) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                title="Lihat cover"
                                            >
                                                <img
                                                    src="{{ asset('storage/' . $item->cover) }}"
                                                    alt="Cover {{ $item->judul }}"
                                                    style="width: 80px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border); transition: transform .15s ease;"
                                                    onmouseover="this.style.transform='scale(1.05)'"
                                                    onmouseout="this.style.transform='scale(1)'"
                                                >
                                            </a>
                                        @else
                                            <div style="width: 80px; height: 60px; border-radius: 6px; background: var(--surface-2); display: grid; place-items: center; color: var(--muted); font-size: 18px; border: 1px solid var(--border);">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <strong>{{ $item->judul }}</strong>
                                    </td>

                                    <td>
                                        @if ($item->deskripsi)
                                            <span style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; color: var(--text-2); font-size: 13px; max-width: 320px;">
                                                {{ $item->deskripsi }}
                                            </span>
                                        @else
                                            <span class="muted-text">-</span>
                                        @endif
                                    </td>

                                    <td style="text-align: center;">
                                        @php
                                            $statusMap = [
                                                'published' => ['label' => 'Published', 'tone' => 'tone-success'],
                                                'archived' => ['label' => 'Archived', 'tone' => 'tone-info'],
                                                'draft' => ['label' => 'Draft', 'tone' => 'tone-warning'],
                                            ];
                                            $statusInfo = $statusMap[$item->status] ?? ['label' => ucfirst($item->status), 'tone' => ''];
                                        @endphp

                                        <span class="badge {{ $statusInfo['tone'] }}">
                                            {{ $statusInfo['label'] }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="row-actions" style="justify-content: flex-end;">
                                            <a
                                                href="{{ route('admin.galeri-album.edit', $item) }}"
                                                class="icon-btn sm edit"
                                                title="Edit album"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form
                                                action="{{ route('admin.galeri-album.destroy', $item) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus album ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="icon-btn sm danger"
                                                    title="Hapus album"
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
                @if ($album->hasPages())
                    <div class="pagination" style="margin-top: 20px;">
                        {{ $album->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection