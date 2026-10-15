@extends('layouts.admin')

@section('title', 'Tambah Album')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Tambah Album</h1>
            <p>Tambahkan album foto untuk website desa.</p>
        </div>

        <a href="{{ route('admin.galeri-album.index') }}" class="btn btn-ghost">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-head">
            <div>
                <h3>Form Album Galeri</h3>
                <p>Isi data album dengan lengkap dan benar.</p>
            </div>
            <i class="bi bi-images" style="font-size: 20px; color: var(--muted);"></i>
        </div>

        <form
            action="{{ route('admin.galeri-album.store') }}"
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
                    {{-- Judul Album --}}
                    <div class="field">
                        <label for="judul">Judul Album</label>
                        <input
                            type="text"
                            id="judul"
                            name="judul"
                            class="input"
                            value="{{ old('judul') }}"
                            placeholder="Contoh: Kegiatan Desa"
                            maxlength="255"
                            required
                        >
                        <small class="field-hint">Judul akan otomatis menjadi slug saat disimpan.</small>
                    </div>

                    {{-- Status --}}
                    <div class="field">
                        <label for="status">Status</label>
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
                        <small class="field-hint">Status menentukan visibilitas album di website.</small>
                    </div>

                    {{-- Deskripsi (Full Width) --}}
                    <div class="field" style="grid-column: 1 / -1;">
                        <label for="deskripsi">Deskripsi Album</label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            class="input"
                            rows="4"
                            maxlength="255"
                            placeholder="Tuliskan deskripsi singkat album"
                            required
                        >{{ old('deskripsi') }}</textarea>
                        <small class="field-hint">Deskripsi singkat mengenai isi album.</small>
                    </div>

                    {{-- Cover Album --}}
                    <div class="field">
                        <label for="cover">Cover Album</label>
                        <input
                            type="file"
                            id="cover"
                            name="cover"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp"
                            required
                        >
                        <small class="field-hint">Format JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.</small>
                    </div>

                    {{-- Pratinjau Cover --}}
                    <div class="field">
                        <label>Pratinjau Cover</label>
                        <img
                            id="cover-preview"
                            src=""
                            alt="Pratinjau cover album"
                            style="display:none; width:200px; max-height:160px; object-fit:cover; border-radius:8px; border: 1px solid var(--border);"
                        >
                        <small class="field-hint" id="cover-preview-hint">Belum ada gambar yang dipilih.</small>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('admin.galeri-album.index') }}" class="btn btn-ghost">
                    <i class="bi bi-x-lg"></i>
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i>
                    Simpan Album
                </button>
            </div>
        </form>
    </div>

    {{-- Script untuk pratinjau cover --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const coverInput = document.getElementById('cover');
            const preview = document.getElementById('cover-preview');
            const previewHint = document.getElementById('cover-preview-hint');

            if (!coverInput) return;

            coverInput.addEventListener('change', function (event) {
                const file = event.target.files[0];

                if (!file) {
                    preview.src = '';
                    preview.style.display = 'none';
                    previewHint.textContent = 'Belum ada gambar yang dipilih.';
                    return;
                }

                if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                    alert('Pilih gambar JPG, PNG, atau WEBP.');
                    event.target.value = '';
                    preview.src = '';
                    preview.style.display = 'none';
                    previewHint.textContent = 'Belum ada gambar yang dipilih.';
                    return;
                }

                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
                previewHint.textContent = 'Pratinjau: ' + file.name;
            });
        });
    </script>
@endsection