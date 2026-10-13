@extends('layouts.admin')

@section('title', 'Edit Menu Website')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Edit Menu Website</h1>
            <p>Ubah informasi dan pengaturan menu navigasi website desa.</p>
        </div>

        <a href="{{ route('admin.menu.index') }}" class="btn btn-ghost">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-head">
            <div>
                <h3>Form Edit Menu</h3>
                <p>Perbarui data menu sesuai kebutuhan.</p>
            </div>
            <i class="bi bi-pencil-square" style="font-size: 20px; color: var(--muted);"></i>
        </div>

        <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST">
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
                    {{-- Nama Menu --}}
                    <div class="field">
                        <label for="label">Nama Menu</label>
                        <input
                            type="text"
                            id="label"
                            name="label"
                            class="input"
                            value="{{ old('label', $menu->label) }}"
                            placeholder="Contoh: Profil Desa"
                            maxlength="255"
                            required
                        >
                    </div>

                    {{-- URL Menu --}}
                    <div class="field">
                        <label for="url">URL Menu</label>
                        <input
                            type="text"
                            id="url"
                            name="url"
                            class="input"
                            value="{{ old('url', $menu->url) }}"
                            placeholder="Contoh: /profil-desa"
                            maxlength="255"
                            required
                        >
                        <small class="field-hint">Masukkan alamat tujuan ketika menu diklik.</small>
                    </div>

                    {{-- Menu Induk --}}
                    <div class="field">
                        <label for="parent_id">Menu Induk</label>
                        <select
                            id="parent_id"
                            name="parent_id"
                            class="input"
                        >
                            <option value="">Menu Utama (Tanpa Induk)</option>

                            @foreach ($parentMenus as $parent)
                                <option
                                    value="{{ $parent->id }}"
                                    @selected(old('parent_id', $menu->parent_id) == $parent->id)
                                >
                                    {{ $parent->label }}
                                </option>
                            @endforeach
                        </select>
                        <small class="field-hint">Pilih menu induk jika menu ini merupakan submenu.</small>
                    </div>

                    {{-- Urutan Menu --}}
                    <div class="field">
                        <label for="urutan">Urutan Menu</label>
                        <input
                            type="number"
                            id="urutan"
                            name="urutan"
                            class="input"
                            value="{{ old('urutan', $menu->urutan) }}"
                            min="0"
                            max="32767"
                            required
                        >
                        <small class="field-hint">Angka lebih kecil ditampilkan lebih dahulu.</small>
                    </div>

                    {{-- Status Menu --}}
                    <div class="field">
                        <label for="is_active">Status Menu</label>
                        <select
                            id="is_active"
                            name="is_active"
                            class="input"
                            required
                        >
                            <option
                                value="1"
                                @selected((string) old('is_active', (int) $menu->is_active) === '1')
                            >
                                Aktif
                            </option>

                            <option
                                value="0"
                                @selected((string) old('is_active', (int) $menu->is_active) === '0')
                            >
                                Tidak Aktif
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('admin.menu.index') }}" class="btn btn-ghost">
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