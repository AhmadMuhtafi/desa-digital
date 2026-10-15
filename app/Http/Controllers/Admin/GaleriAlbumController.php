<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GaleriAlbumController extends Controller
{
    public function index()
    {
        $album = GaleriAlbum::orderByDesc('id')->paginate(10);

        return view('admin.galeri-album.index', compact('album'));
    }

    public function create()
    {
        return view('admin.galeri-album.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:255'],
            'cover' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'status' => [
                'required',
                Rule::in(['draft', 'published', 'archived']),
            ],
        ]);

        $data['cover'] = $request->file('cover')
            ->store('galeri/cover', 'public');

        GaleriAlbum::create($data);

        return redirect()
            ->route('admin.galeri-album.index')
            ->with('success', 'Album galeri berhasil ditambahkan.');
    }

    public function show(GaleriAlbum $galeriAlbum)
    {
        return redirect()->route(
            'admin.galeri-album.edit',
            $galeriAlbum
        );
    }

    public function edit(GaleriAlbum $galeriAlbum)
    {
        $album = $galeriAlbum;

        return view('admin.galeri-album.edit', compact('album'));
    }

    public function update(Request $request, GaleriAlbum $galeriAlbum)
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:255'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'status' => [
                'required',
                Rule::in(['draft', 'published', 'archived']),
            ],
        ]);

        if ($request->hasFile('cover')) {
            if ($galeriAlbum->cover) {
                Storage::disk('public')->delete($galeriAlbum->cover);
            }

            $data['cover'] = $request->file('cover')
                ->store('galeri/cover', 'public');
        } else {
            unset($data['cover']);
        }

        $galeriAlbum->update($data);

        return redirect()
            ->route('admin.galeri-album.index')
            ->with('success', 'Album galeri berhasil diperbarui.');
    }
    
    public function destroy(GaleriAlbum $galeriAlbum)
    {
        // Hapus file cover dari storage jika tersedia.
        if ($galeriAlbum->cover) {
            Storage::disk('public')->delete($galeriAlbum->cover);
        }

        // Hapus data album dari database.
        $galeriAlbum->delete();

        return redirect()
            ->route('admin.galeri-album.index')
            ->with('success', 'Album galeri berhasil dihapus.');
    }

}
