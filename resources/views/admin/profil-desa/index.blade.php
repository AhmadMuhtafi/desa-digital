@extends('layouts.admin')

@section('title', 'Profil Desa')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Profil Desa</h1>
            <p>Kelola identitas, visi, dan misi desa.</p>
        </div>
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

    {{-- Alert Error --}}
    @if ($errors->any())
        <div class="alert alert-danger" role="alert" style="display: flex; align-items: flex-start; gap: 8px; padding: 12px 16px; border-radius: var(--radius-sm); background-color: var(--danger-soft); color: var(--danger); border: 1px solid var(--danger); margin-bottom: 20px;">
            <i class="bi bi-exclamation-circle-fill" style="font-size: 16px; margin-top: 2px;"></i>
            <div>
                <strong>Profil desa gagal disimpan.</strong>
                <ul style="margin: 4px 0 0 0; padding-left: 16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.profil-desa.update') }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Card 1: Identitas Desa --}}
        <div class="card">
            <div class="card-head">
                <div>
                    <h3>Identitas Desa</h3>
                    <p>Masukkan informasi dasar desa sesuai data resmi.</p>
                </div>
                <i class="bi bi-buildings" style="font-size: 20px; color: var(--muted);"></i>
            </div>

            <div class="card-body">
                <div class="form-grid">
                    <div class="field">
                        <label for="nama_desa">Nama Desa</label>
                        <input
                            type="text"
                            id="nama_desa"
                            name="nama_desa"
                            class="input"
                            value="{{ old('nama_desa', $profil?->nama_desa ?? '') }}"
                            placeholder="Masukkan nama desa"
                            maxlength="255"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="kecamatan">Kecamatan</label>
                        <input
                            type="text"
                            id="kecamatan"
                            name="kecamatan"
                            class="input"
                            value="{{ old('kecamatan', $profil?->kecamatan ?? '') }}"
                            placeholder="Masukkan nama kecamatan"
                            maxlength="255"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="kabupaten">Kabupaten</label>
                        <input
                            type="text"
                            id="kabupaten"
                            name="kabupaten"
                            class="input"
                            value="{{ old('kabupaten', $profil?->kabupaten ?? '') }}"
                            placeholder="Masukkan nama kabupaten"
                            maxlength="255"
                            required
                        >
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Visi dan Misi --}}
        <div class="card" style="margin-top: 20px;">
            <div class="card-head">
                <div>
                    <h3>Visi dan Misi</h3>
                    <p>Kelola visi dan misi yang akan menjadi informasi profil desa.</p>
                </div>
                <i class="bi bi-bullseye" style="font-size: 20px; color: var(--muted);"></i>
            </div>

            <div class="card-body">
                <div class="form-grid">
                    <div class="field">
                        <label for="visi">Visi Desa</label>
                        <textarea
                            id="visi"
                            name="visi"
                            class="input"
                            rows="5"
                            placeholder="Tuliskan visi desa"
                            required
                        >{{ old('visi', $profil?->visi ?? '') }}</textarea>
                    </div>

                    <div class="field">
                        <label for="misi">Misi Desa</label>
                        <textarea
                            id="misi"
                            name="misi"
                            class="input"
                            rows="7"
                            placeholder="Tuliskan misi desa"
                            required
                        >{{ old('misi', $profil?->misi ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="reset" class="btn btn-ghost">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reset Form
                </button>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i>
                    Simpan Profil Desa
                </button>
            </div>
        </div>
    </form>
@endsection