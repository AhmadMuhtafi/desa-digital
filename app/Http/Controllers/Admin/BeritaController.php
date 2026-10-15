<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::with(['kategori', 'penulis'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        $kategori = Kategori::where('tipe', 'berita')
            ->orderBy('nama')
            ->get();

        return view('admin.berita.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => [
                'required',
                'integer',
                Rule::exists('kategori', 'id')
                    ->where('tipe', 'berita'),
            ],
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'status' => [
                'required',
                Rule::in(['draft', 'published', 'archived']),
            ],
            'published_at' => ['nullable', 'date'],
        ]);

        $data['penulis_id'] = Auth::id();
        $data['slug'] = $this->generateSlug($data['judul']);
        $data['gambar'] = $request->hasFile('gambar')
            ? $request->file('gambar')->store('berita', 'public')
            : null;

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if ($data['status'] !== 'published') {
            $data['published_at'] = null;
        }

        Berita::create($data);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show(Berita $berita)
    {
        return redirect()->route('admin.berita.edit', $berita);
    }

    public function edit(Berita $berita)
    {
        $kategori = Kategori::where('tipe', 'berita')
            ->orderBy('nama')
            ->get();

        return view('admin.berita.edit', compact('berita', 'kategori'));
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $request->validate([
            'kategori_id' => [
                'required',
                'integer',
                Rule::exists('kategori', 'id')
                    ->where('tipe', 'berita'),
            ],
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'status' => [
                'required',
                Rule::in(['draft', 'published', 'archived']),
            ],
            'published_at' => ['nullable', 'date'],
        ]);

        $data['slug'] = $this->generateSlug(
            $data['judul'],
            $berita->id
        );

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }

            $data['gambar'] = $request->file('gambar')
                ->store('berita', 'public');
        } else {
            unset($data['gambar']);
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = $berita->published_at ?? now();
        }

        if ($data['status'] !== 'published') {
            $data['published_at'] = null;
        }

        $berita->update($data);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    private function generateSlug(
        string $judul,
        ?int $excludeId = null
    ): string {
        $slugDasar = Str::slug($judul);

        if ($slugDasar === '') {
            $slugDasar = 'berita';
        }

        $slug = $slugDasar;
        $nomor = 2;

        while (
            Berita::where('slug', $slug)
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
