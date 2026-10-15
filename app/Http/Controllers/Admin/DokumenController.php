<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DokumenController extends Controller
{
    public function index()
    {
        $dokumen = Dokumen::with('kategori')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.dokumen.index', compact('dokumen'));
    }

    public function create()
    {
        $kategori = Kategori::where('tipe', 'dokumen')
            ->orderBy('nama')
            ->get();

        return view('admin.dokumen.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => [
                'required',
                'integer',
                Rule::exists('kategori', 'id')
                    ->where('tipe', 'dokumen'),
            ],
            'judul' => ['required', 'string', 'max:255'],
            'file' => [
                'required',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
                'max:10240',
            ],
            'status' => [
                'required',
                Rule::in(['draft', 'published', 'archived']),
            ],
        ]);

        $file = $request->file('file');
        $namaFile = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('dokumen', $namaFile, 'public');

        $data['file'] = $path;
        $data['tipe_file'] = strtolower($file->getClientOriginalExtension());
        $data['jumlah_unduh'] = 0;

        Dokumen::create($data);

        return redirect()
            ->route('admin.dokumen.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function show(Dokumen $dokumen)
    {
        return redirect()->route('admin.dokumen.edit', $dokumen);
    }

    public function edit(Dokumen $dokumen)
    {
        $kategori = Kategori::where('tipe', 'dokumen')
            ->orderBy('nama')
            ->get();

        return view('admin.dokumen.edit', compact('dokumen', 'kategori'));
    }

    public function update(Request $request, Dokumen $dokumen)
    {
        $data = $request->validate([
            'kategori_id' => [
                'required',
                'integer',
                Rule::exists('kategori', 'id')
                    ->where('tipe', 'dokumen'),
            ],
            'judul' => ['required', 'string', 'max:255'],
            'file' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
                'max:10240',
            ],
            'status' => [
                'required',
                Rule::in(['draft', 'published', 'archived']),
            ],
        ]);

        if ($request->hasFile('file')) {
            if ($dokumen->file) {
                Storage::disk('public')->delete($dokumen->file);
            }

            $file = $request->file('file');
            $namaFile = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $data['file'] = $file->storeAs(
                'dokumen',
                $namaFile,
                'public'
            );

            $data['tipe_file'] = strtolower(
                $file->getClientOriginalExtension()
            );
        } else {
            unset($data['file']);
        }

        $dokumen->update($data);

        return redirect()
            ->route('admin.dokumen.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Dokumen $dokumen)
    {
        if ($dokumen->file) {
            Storage::disk('public')->delete($dokumen->file);
        }

        $dokumen->delete();

        return redirect()
            ->route('admin.dokumen.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}
