@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Edit Kategori</h1>
            <p>Ubah nama dan tipe kategori website desa.</p>
        </div>

        <a href="{{ route('admin.kategori.index') }}" class="btn btn-ghost">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-head">
            <div>
                <h3>Form Edit Kategori</h3>
                <p>Perbarui data kategori sesuai kebutuhan.</p>
            </div>
            <i class="bi bi-pencil-square" style="font-size: 20px; color: var(--muted);"></i>
        </div>

        <form
            action="{{ route('admin.kategori.update', $kategori->id) }}"
            method="POST"
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
                    {{-- Nama Kategori --}}
                    <div class="field">
                        <label for="nama">Nama Kategori</label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            class="input"
                            value="{{ old('nama', $kategori->nama) }}"
                            placeholder="Contoh: Berita Desa"
                            maxlength="255"
                            required
                        >
                        <small class="field-hint">Masukkan nama kategori yang jelas dan singkat.</small>
                    </div>

                    {{-- Tipe Kategori --}}
                    <div class="field">
                        <label for="tipe">Tipe Kategori</label>
                        <select
                            id="tipe"
                            name="tipe"
                            class="input"
                            required
                        >
                            <option value="berita"
                                @selected(old('tipe', $kategori->tipe) === 'berita')>
                                Berita
                            </option>

                            <option value="dokumen"
                                @selected(old('tipe', $kategori->tipe) === 'dokumen')>
                                Dokumen
                            </option>

                            <option value="potensi"
                                @selected(old('tipe', $kategori->tipe) === 'potensi')>
                                Potensi Desa
                            </option>
                        </select>
                        <small class="field-hint">Pilih tipe kategori sesuai konten yang akan dikelompokkan.</small>
                    </div>

                    {{-- Slug Kategori (Readonly) --}}
                    <div class="field">
                        <label for="slug">Slug Kategori</label>
                        <input
                            type="text"
                            id="slug"
                            class="input"
                            value="{{ $kategori->slug }}"
                            readonly
                        >
                        <small class="field-hint">
                            Slug akan dibuat ulang secara otomatis saat perubahan disimpan.
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-ghost">
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