<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::orderBy('tipe')
            ->orderBy('nama')
            ->paginate(10);

        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipe' => [
                'required',
                Rule::in(['berita', 'dokumen', 'potensi']),
            ],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $data['slug'] = $this->generateSlug($data['nama']);

        Kategori::create($data);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'tipe' => [
                'required',
                Rule::in(['berita', 'dokumen', 'potensi']),
            ],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $data['slug'] = $this->generateSlug(
            $data['nama'],
            $kategori->id
        );

        $kategori->update($data);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $referensi = [
            'berita',
            'dokumen',
            'potensi_desa',
        ];

        foreach ($referensi as $tabel) {
            if (
                Schema::hasTable($tabel) &&
                DB::table($tabel)
                    ->where('kategori_id', $kategori->id)
                    ->exists()
            ) {
                return redirect()
                    ->route('admin.kategori.index')
                    ->with(
                        'error',
                        'Kategori tidak dapat dihapus karena masih digunakan oleh data '
                        . str_replace('_', ' ', $tabel)
                        . '.'
                    );
            }
        }

        $kategori->delete();

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    private function generateSlug(
        string $nama,
        ?int $excludeId = null
    ): string {
        $slugDasar = Str::slug($nama);

        if ($slugDasar === '') {
            $slugDasar = 'kategori';
        }

        $slug = $slugDasar;
        $nomor = 2;

        while (
            Kategori::where('slug', $slug)
                ->when(
                    $excludeId !== null,
                    fn ($query) => $query->where('id', '!=', $excludeId)
                )
                ->exists()
        ) {
            $slug = $slugDasar . '-' . $nomor;
            $nomor++;
        }

        return $slug;
    }
}