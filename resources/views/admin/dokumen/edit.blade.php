@extends('layouts.admin')

@section('title', 'Edit Dokumen')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Edit Dokumen</h1>
            <p>Perbarui informasi atau file dokumen.</p>
        </div>

        <a href="{{ route('admin.dokumen.index') }}" class="btn btn-ghost">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-head">
            <div>
                <h3>Form Edit Dokumen</h3>
                <p>Perbarui data dokumen sesuai kebutuhan.</p>
            </div>
            <i class="bi bi-pencil-square" style="font-size: 20px; color: var(--muted);"></i>
        </div>

        <form
            action="{{ route('admin.dokumen.update', $dokumen) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

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
                            value="{{ old('judul', $dokumen->judul) }}"
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
                                    @selected(old('kategori_id', $dokumen->kategori_id) == $item->id)
                                >
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>

                        @if ($kategori->isEmpty())
                            <small class="field-hint" style="color: var(--warning);">
                                <i class="bi bi-exclamation-triangle"></i>
                                Belum ada kategori bertipe dokumen. Tambahkan kategori terlebih dahulu.
                            </small>
                        @else
                            <small class="field-hint">Pilih kategori yang sesuai dengan dokumen.</small>
                        @endif
                    </div>

                    {{-- File Saat Ini --}}
                    <div class="field" style="grid-column: 1 / -1;">
                        <label>File Saat Ini</label>

                        @if ($dokumen->file)
                            <div style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface-2);">
                                <div style="width: 40px; height: 40px; border-radius: 8px; display: grid; place-items: center; background: var(--primary-soft); color: var(--primary); font-size: 18px; flex-shrink: 0;">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-weight: 600; font-size: 13px;">
                                        Dokumen Tersimpan
                                    </div>
                                    <div class="muted-text" style="font-size: 12.5px; margin-top: 2px;">
                                        Tipe: {{ strtoupper($dokumen->tipe_file) }}
                                    </div>
                                </div>
                                <a
                                    href="{{ asset('storage/' . $dokumen->file) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn btn-ghost btn-sm"
                                >
                                    <i class="bi bi-eye"></i>
                                    Lihat
                                </a>
                            </div>
                        @else
                            <div class="muted-text" style="padding: 12px 16px; border: 1px dashed var(--border); border-radius: var(--radius-sm); text-align: center;">
                                Belum ada file yang diunggah.
                            </div>
                        @endif
                    </div>

                    {{-- Ganti File --}}
                    <div class="field">
                        <label for="file">Ganti File (Opsional)</label>
                        <input
                            type="file"
                            id="file"
                            name="file"
                            class="form-control"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                        >
                        <small class="field-hint">
                            Kosongkan jika tidak ingin mengganti file. Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX. Maksimal 10 MB.
                        </small>
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
                            <option value="draft" @selected(old('status', $dokumen->status) === 'draft')>
                                Draft
                            </option>
                            <option value="published" @selected(old('status', $dokumen->status) === 'published')>
                                Published
                            </option>
                            <option value="archived" @selected(old('status', $dokumen->status) === 'archived')>
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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection