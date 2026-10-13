@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
    {{-- Page Head --}}
    <div class="page-head">
        <div>
            <h1>Pengaturan Website</h1>
            <p>Kelola informasi dan konfigurasi dasar website desa.</p>
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
                <strong>Pengaturan gagal disimpan.</strong>
                <ul style="margin: 4px 0 0 0; padding-left: 16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @php
        $daftarPengaturan = [
            'nama_website' => [
                'label' => 'Nama Website',
                'placeholder' => 'Contoh: Website Desa Digital',
                'type' => 'text',
                'description' => 'Nama website yang digunakan.',
            ],
            'deskripsi_website' => [
                'label' => 'Deskripsi Website',
                'placeholder' => 'Masukkan deskripsi singkat website',
                'type' => 'textarea',
                'description' => 'Deskripsi singkat mengenai website desa.',
            ],
            'meta_title' => [
                'label' => 'Meta Title',
                'placeholder' => 'Judul website untuk mesin pencari',
                'type' => 'text',
                'description' => 'Judul yang dapat digunakan pada metadata website.',
            ],
            'meta_description' => [
                'label' => 'Meta Description',
                'placeholder' => 'Deskripsi website untuk mesin pencari',
                'type' => 'textarea',
                'description' => 'Ringkasan website untuk metadata mesin pencari.',
            ],
        ];

        $nilaiPengaturan = $pengaturan->pluck('nilai', 'kunci')->all();
    @endphp

    <form action="{{ route('admin.pengaturan.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            {{-- Card Head --}}
            <div class="card-head">
                <div>
                    <h3>Informasi Website</h3>
                    <p>Atur informasi dasar yang digunakan website.</p>
                </div>
                <i class="bi bi-globe2" style="font-size: 20px; color: var(--muted);"></i>
            </div>

            {{-- Card Body --}}
            <div class="card-body">
                <div class="form-grid">
                    @foreach ($daftarPengaturan as $kunci => $item)
                        <div class="field">
                            <label for="{{ $kunci }}">
                                {{ $item['label'] }}
                            </label>

                            @if ($item['type'] === 'textarea')
                                <textarea
                                    id="{{ $kunci }}"
                                    name="pengaturan[{{ $kunci }}]"
                                    class="input"
                                    rows="4"
                                    placeholder="{{ $item['placeholder'] }}"
                                >{{ old("pengaturan.$kunci", $nilaiPengaturan[$kunci] ?? '') }}</textarea>
                            @else
                                <input
                                    type="text"
                                    id="{{ $kunci }}"
                                    name="pengaturan[{{ $kunci }}]"
                                    class="input"
                                    value="{{ old("pengaturan.$kunci", $nilaiPengaturan[$kunci] ?? '') }}"
                                    placeholder="{{ $item['placeholder'] }}"
                                >
                            @endif

                            <small class="field-hint">{{ $item['description'] }}</small>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Card Footer --}}
            <div class="card-footer">
                <button type="reset" class="btn btn-ghost">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reset Form
                </button>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </div>
    </form>
@endsection