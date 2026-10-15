@extends('layouts.admin')

@section('title', 'Tambah Dokumen')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Tambah Dokumen</h1>
            <p>Tambahkan dokumen baru ke website Desa Digital.</p>
        </div>

        <a href="{{ route('admin.dokumen.index') }}" class="btn btn-ghost">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-head">
            <div>
                <h3>Form Dokumen</h3>
                <p>Isi data dokumen dengan lengkap dan benar.</p>
            </div>
            <i class="bi bi-file-earmark-plus" style="font-size: 20px; color: var(--muted);"></i>
        </div>

        <form
            action="{{ route('admin.dokumen.store') }}"
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
                    {{-- Judul Dokumen --}}
                    <div class="field">
                        <label for="judul">Judul Dokumen</label>
                        <input
                            type="text"
                            id="judul"
                            name="judul"
                            class="input"
                            value="{{ old('judul') }}"
                            placeholder="Masukkan judul dokumen"
                            maxlength="255"
                            required
                        >
                        <small class="field-hint">Judul akan otomatis menjadi slug saat disimpan.</small>
                    </div>

                    {{-- Kategori --}}
                    <div class="field">
                        <label for="kategori_id">Kategori</label>
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
                                Belum ada kategori dokumen. Tambahkan kategori dengan tipe "dokumen" terlebih dahulu.
                            </small>
                        @else
                            <small class="field-hint">Pilih kategori yang sesuai dengan dokumen.</small>
                        @endif
                    </div>

                    {{-- File Dokumen (dengan Preview) --}}
                    <div class="field" style="grid-column: 1 / -1;">
                        <label for="file">File Dokumen</label>
                        <input
                            type="file"
                            id="file"
                            name="file"
                            class="form-control"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                            required
                        >
                        <small class="field-hint">
                            Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX. Maksimal 10 MB.
                        </small>

                        {{-- Preview File Terpilih --}}
                        <div id="file-preview" style="display: none; margin-top: 12px; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface-2); align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 8px; display: grid; place-items: center; background: var(--primary-soft); color: var(--primary); font-size: 18px; flex-shrink: 0;">
                                <i class="bi bi-file-earmark-check"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; font-size: 13px;">
                                    File Terpilih
                                </div>
                                <div class="muted-text" id="file-name" style="font-size: 12.5px; margin-top: 2px; word-break: break-all;">
                                    -
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="field">
                        <label for="status">Status</label>
                        <select
                            id="status"
                            name="status"
                            class="input"
                            required
                        >
                            <option value="draft" @selected(old('status', 'draft') === 'draft')>
                                Draft
                            </option>
                            <option value="published" @selected(old('status') === 'published')>
                                Published
                            </option>
                            <option value="archived" @selected(old('status') === 'archived')>
                                Archived
                            </option>
                        </select>
                        <small class="field-hint">Status menentukan visibilitas dokumen di website.</small>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('admin.dokumen.index') }}" class="btn btn-ghost">
                    <i class="bi bi-x-lg"></i>
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i>
                    Simpan Dokumen
                </button>
            </div>
        </form>
    </div>

    {{-- Script untuk Preview Nama File --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('file');
            const filePreview = document.getElementById('file-preview');
            const fileName = document.getElementById('file-name');

            if (fileInput) {
                fileInput.addEventListener('change', function () {
                    if (this.files && this.files.length > 0) {
                        const file = this.files[0];
                        const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);

                        fileName.textContent = file.name + ' (' + sizeInMB + ' MB)';
                        filePreview.style.display = 'flex';
                    } else {
                        filePreview.style.display = 'none';
                        fileName.textContent = '-';
                    }
                });
            }
        });
    </script>
@endsection