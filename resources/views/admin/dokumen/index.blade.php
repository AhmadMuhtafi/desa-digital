@extends('layouts.admin')

@section('title', 'Dokumen')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Dokumen</h1>
            <p>Kelola dokumen dan file untuk website Desa Digital.</p>
        </div>

        <a href="{{ route('admin.dokumen.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Tambah Dokumen
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
                <h3>Daftar Dokumen</h3>
                <p>Total {{ $dokumen->total() }} dokumen tersimpan di sistem.</p>
            </div>
            <i class="bi bi-file-earmark-text" style="font-size: 20px; color: var(--muted);"></i>
        </div>

        <div class="card-body">
            @if ($dokumen->isEmpty())
                {{-- Empty State --}}
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <h4>Belum Ada Dokumen</h4>
                    <p>Silakan tambahkan dokumen pertama untuk mulai mengelola file desa.</p>
                    <a href="{{ route('admin.dokumen.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Dokumen
                    </a>
                </div>
            @else
                {{-- Table --}}
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 60px;">No.</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th style="text-align: center;">Tipe File</th>
                                <th style="text-align: center;">Unduhan</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: right; width: 120px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($dokumen as $item)
                                <tr>
                                    <td>{{ $dokumen->firstItem() + $loop->index }}</td>

                                    <td>
                                        <strong>{{ $item->judul }}</strong>
                                    </td>

                                    <td>
                                        @if ($item->kategori)
                                            <span class="badge tone-info">{{ $item->kategori->nama }}</span>
                                        @else
                                            <span class="muted-text">-</span>
                                        @endif
                                    </td>

                                    <td style="text-align: center;">
                                        @if ($item->tipe_file)
                                            <span class="badge tone-primary">
                                                {{ strtoupper($item->tipe_file) }}
                                            </span>
                                        @else
                                            <span class="muted-text">-</span>
                                        @endif
                                    </td>

                                    <td style="text-align: center;">
                                        <span class="mono">
                                            {{ number_format($item->jumlah_unduh, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td style="text-align: center;">
                                        @php
                                            $statusMap = [
                                                'published' => ['label' => 'Published', 'tone' => 'tone-success'],
                                                'archived' => ['label' => 'Archived', 'tone' => 'tone-info'],
                                                'draft' => ['label' => 'Draft', 'tone' => 'tone-warning'],
                                            ];
                                            $statusInfo = $statusMap[$item->status] ?? ['label' => $item->status, 'tone' => ''];
                                        @endphp

                                        <span class="badge {{ $statusInfo['tone'] }}">
                                            {{ $statusInfo['label'] }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="row-actions" style="justify-content: flex-end;">
                                            {{-- Lihat File --}}
                                            <a
                                                href="{{ asset('storage/' . $item->file) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="icon-btn sm"
                                                title="Lihat file"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            {{-- Edit --}}
                                            <a
                                                href="{{ route('admin.dokumen.edit', $item) }}"
                                                class="icon-btn sm edit"
                                                title="Edit dokumen"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            {{-- Hapus --}}
                                            <form
                                                action="{{ route('admin.dokumen.destroy', $item) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="icon-btn sm danger"
                                                    title="Hapus dokumen"
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
                @if ($dokumen->hasPages())
                    <div class="pagination" style="margin-top: 20px;">
                        {{ $dokumen->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection