@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Kategori</h1>
            <p>Kelola kategori berita, dokumen, dan potensi desa.</p>
        </div>

        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Tambah Kategori
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
                <h3>Daftar Kategori</h3>
                <p>Total {{ $kategori->total() }} kategori tersimpan di sistem.</p>
            </div>
            <i class="bi bi-tags" style="font-size: 20px; color: var(--muted);"></i>
        </div>

        <div class="card-body">
            @if ($kategori->isEmpty())
                {{-- Empty State --}}
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-folder2-open"></i>
                    </div>
                    <h4>Belum Ada Kategori</h4>
                    <p>Silakan tambahkan kategori pertama untuk mulai mengelompokkan konten.</p>
                    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Kategori
                    </a>
                </div>
            @else
                {{-- Table --}}
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 70px;">No.</th>
                                <th>Nama Kategori</th>
                                <th>Tipe</th>
                                <th>Slug</th>
                                <th style="text-align: right; width: 120px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($kategori as $item)
                                <tr>
                                    <td>
                                        {{ $kategori->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        <strong>{{ $item->nama }}</strong>
                                    </td>

                                    <td>
                                        @php
                                            $labelTipe = [
                                                'berita' => 'Berita',
                                                'dokumen' => 'Dokumen',
                                                'potensi' => 'Potensi Desa',
                                            ];
                                        @endphp

                                        <span class="badge tone-info">
                                            {{ $labelTipe[$item->tipe] ?? $item->tipe }}
                                        </span>
                                    </td>

                                    <td>
                                        <code class="mono">{{ $item->slug }}</code>
                                    </td>

                                    <td>
                                        <div class="row-actions" style="justify-content: flex-end;">
                                            <a
                                                href="{{ route('admin.kategori.edit', $item->id) }}"
                                                class="icon-btn sm edit"
                                                title="Edit kategori"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form
                                                action="{{ route('admin.kategori.destroy', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori {{ addslashes($item->nama) }}?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="icon-btn sm danger"
                                                    title="Hapus kategori"
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
                @if ($kategori->hasPages())
                    <div class="pagination" style="margin-top: 20px;">
                        {{ $kategori->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection