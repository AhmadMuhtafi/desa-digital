@extends('layouts.admin')

@section('title', 'Tambah Berita')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Tambah Berita</h1>
            <p>Buat berita baru untuk website desa.</p>
        </div>

        <a href="{{ route('admin.berita.index') }}" class="btn btn-ghost">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-head">
            <div>
                <h3>Form Tambah Berita</h3>
                <p>Isi data berita dengan lengkap dan benar.</p>
            </div>
            <i class="bi bi-newspaper" style="font-size: 20px; color: var(--muted);"></i>
        </div>

        <form
            action="{{ route('admin.berita.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="card-body">
                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert" style="display: flex; align-items: flex-start; gap: 8px; padding: 12px 16px; border-radius: var(--radius-sm); background-color: var(--danger-soft); color: var(--danger); border: 1px solid var(--danger); margin-bottom: 20px;">
                        <i class="bi bi-exclamation-circle-fill" style="font-size: 16px; margin-top: 2px;"></i>
                        <div>
                            <strong>Periksa kembali data yang dimasukkan.</strong>
                            <ul style="margin: 4px 0 0 0; padding-left: 16px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="form-grid">
                    {{-- Judul Berita --}}
                    <div class="field">
                        <label for="judul">Judul Berita</label>
                        <input
                            type="text"
                            id="judul"
                            name="judul"
                            class="input"
                            value="{{ old('judul') }}"
                            placeholder="Masukkan judul berita"
                            maxlength="255"
                            required
                        >
                        <small class="field-hint">Judul akan otomatis menjadi slug saat disimpan.</small>
                    </div>

                    {{-- Kategori Berita --}}
                    <div class="field">
                        <label for="kategori_id">Kategori Berita</label>
                        <select
                            id="kategori_id"
                            name="kategori_id"
                            class="input"
                            required
                        >
                            <option value="">-- Pilih Kategori --</option>

                            @foreach ($kategori as $item)
                                <option
                                    value="{{ $item->id }}"
                                    @selected(old('kategori_id') == $item->id)
                                >
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>

                        @if ($kategori->isEmpty())
                            <small class="field-hint" style="color: var(--warning);">
                                <i class="bi bi-exclamation-triangle"></i>
                                Belum ada kategori berita. Tambahkan kategori dengan tipe Berita terlebih dahulu.
                            </small>
                        @else
                            <small class="field-hint">Pilih kategori yang sesuai dengan berita.</small>
                        @endif
                    </div>

                    {{-- Gambar Berita --}}
                    <div class="field">
                        <label for="gambar">Gambar Berita</label>
                        <input
                            type="file"
                            id="gambar"
                            name="gambar"
                            class="form-control"
                            accept="image/*"
                        >
                        <small class="field-hint">Format gambar yang didukung Laravel, maksimal 2 MB.</small>
                    </div>

                    {{-- Status Berita --}}
                    <div class="field">
                        <label for="status">Status Berita</label>
                        <select id="status" name="status" class="input" required>
                            <option value="draft" @selected(old('status', 'draft') === 'draft')>
                                Draft
                            </option>
                            <option value="published" @selected(old('status') === 'published')>
                                Dipublikasikan
                            </option>
                            <option value="archived" @selected(old('status') === 'archived')>
                                Diarsipkan
                            </option>
                        </select>
                        <small class="field-hint">Status menentukan visibilitas berita di website.</small>
                    </div>

                    {{-- Tanggal Publikasi (Hidden jika bukan published) --}}
                    <div class="field" id="field-published-at">
                        <label for="published_at">Tanggal Publikasi</label>
                        <input
                            type="datetime-local"
                            id="published_at"
                            name="published_at"
                            class="input"
                            value="{{ old('published_at') }}"
                        >
                        <small class="field-hint">
                            Boleh dikosongkan. Jika status Dipublikasikan, waktu akan diisi otomatis.
                        </small>
                    </div>

                    {{-- Isi Berita (Full Width) --}}
                    <div class="field" style="grid-column: 1 / -1;">
                        <label for="isi">Isi Berita</label>
                        <textarea
                            id="isi"
                            name="isi"
                            class="input"
                            rows="10"
                            placeholder="Tulis isi berita di sini..."
                            required
                        >{{ old('isi') }}</textarea>
                        <small class="field-hint">Gunakan editor atau tulis langsung isi berita di sini.</small>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('admin.berita.index') }}" class="btn btn-ghost">
                    <i class="bi bi-x-lg"></i>
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i>
                    Simpan Berita
                </button>
            </div>
        </form>
    </div>

    {{-- Script untuk toggle visibility field Tanggal Publikasi --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status');
            const fieldPublishedAt = document.getElementById('field-published-at');
            const publishedAtInput = document.getElementById('published_at');

            function togglePublishedAt() {
                if (statusSelect.value === 'published') {
                    fieldPublishedAt.style.display = 'flex';
                } else {
                    fieldPublishedAt.style.display = 'none';
                    // Kosongkan nilai saat di-hide agar tidak tersimpan di database
                    publishedAtInput.value = '';
                }
            }

            // Jalankan saat halaman dimuat
            togglePublishedAt();

            // Jalankan setiap kali status berubah
            statusSelect.addEventListener('change', togglePublishedAt);
        });
    </script>
@endsection