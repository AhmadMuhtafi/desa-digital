@extends('layouts.admin')

@section('title', 'Kontak Desa')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Kontak Desa</h1>
            <p>Kelola alamat, nomor telepon, jam pelayanan, dan lokasi kantor desa.</p>
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
                <strong>Kontak desa gagal disimpan.</strong>
                <ul style="margin: 4px 0 0 0; padding-left: 16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.kontak-desa.update') }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Card 1: Informasi Kontak --}}
        <div class="card">
            <div class="card-head">
                <div>
                    <h3>Informasi Kontak</h3>
                    <p>Informasi yang dapat digunakan masyarakat untuk menghubungi kantor desa.</p>
                </div>
                <i class="bi bi-telephone" style="font-size: 20px; color: var(--muted);"></i>
            </div>

            <div class="card-body">
                <div class="form-grid">
                    <div class="field">
                        <label for="alamat">Alamat Kantor Desa</label>
                        <textarea
                            id="alamat"
                            name="alamat"
                            class="input"
                            rows="3"
                            placeholder="Masukkan alamat lengkap kantor desa"
                            maxlength="255"
                            required
                        >{{ old('alamat', $kontak?->alamat ?? '') }}</textarea>
                    </div>

                    <div class="field">
                        <label for="telepon">Nomor Telepon</label>
                        <input
                            type="text"
                            id="telepon"
                            name="telepon"
                            class="input"
                            value="{{ old('telepon', $kontak?->telepon ?? '') }}"
                            placeholder="Contoh: 08xxxxxxxxxx"
                            maxlength="255"
                            required
                        >
                        <small class="field-hint">Gunakan format nomor telepon yang benar.</small>
                    </div>

                    <div class="field">
                        <label for="jam_pelayanan">Jam Pelayanan</label>
                        <textarea
                            id="jam_pelayanan"
                            name="jam_pelayanan"
                            class="input"
                            rows="4"
                            placeholder="Contoh:
Senin–Jumat: 08.00–15.00
Sabtu–Minggu: Tutup"
                            required
                        >{{ old('jam_pelayanan', $kontak?->jam_pelayanan ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Lokasi Kantor Desa --}}
        <div class="card" style="margin-top: 20px;">
            <div class="card-head">
                <div>
                    <h3>Lokasi Kantor Desa</h3>
                    <p>Masukkan koordinat geografis dan radius lokasi dalam meter.</p>
                </div>
                <i class="bi bi-geo-alt" style="font-size: 20px; color: var(--muted);"></i>
            </div>

            <div class="card-body">
                <div class="form-grid">
                    <div class="field">
                        <label for="latitude">Latitude</label>
                        <input
                            type="number"
                            id="latitude"
                            name="latitude"
                            class="input"
                            value="{{ old('latitude', $kontak?->latitude ?? '') }}"
                            placeholder="Contoh: -6.9667"
                            min="-90"
                            max="90"
                            step="any"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="longitude">Longitude</label>
                        <input
                            type="number"
                            id="longitude"
                            name="longitude"
                            class="input"
                            value="{{ old('longitude', $kontak?->longitude ?? '') }}"
                            placeholder="Contoh: 110.4167"
                            min="-180"
                            max="180"
                            step="any"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="radius_meter">Radius (meter)</label>
                        <input
                            type="number"
                            id="radius_meter"
                            name="radius_meter"
                            class="input"
                            value="{{ old('radius_meter', $kontak?->radius_meter ?? '') }}"
                            placeholder="Contoh: 100"
                            min="1"
                            step="1"
                            required
                        >
                        <small class="field-hint">Isi sesuai radius yang dibutuhkan dalam satuan meter.</small>
                    </div>
                </div>

                {{-- Tombol Buka Google Maps --}}
                <div style="margin-top: 20px;">
                    <a
                        href="https://www.google.com/maps"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn-ghost"
                    >
                        <i class="bi bi-map"></i>
                        Buka Google Maps
                    </a>
                    <small class="field-hint" style="display: block; margin-top: 8px;">
                        Gunakan Google Maps untuk mencari koordinat lokasi kantor desa yang tepat.
                    </small>
                </div>
            </div>

            <div class="card-footer">
                <button type="reset" class="btn btn-ghost">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reset Form
                </button>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i>
                    Simpan Kontak Desa
                </button>
            </div>
        </div>
    </form>
@endsection