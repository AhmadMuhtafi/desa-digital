<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilDesa;
use Illuminate\Http\Request;

class ProfilDesaController extends Controller
{
    public function index()
    {
        $profil = ProfilDesa::find(1);

        return view('admin.profil-desa.index', compact('profil'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nama_desa' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kabupaten' => ['required', 'string', 'max:255'],
            'visi' => ['required', 'string'],
            'misi' => ['required', 'string'],
        ]);

        ProfilDesa::updateOrCreate(
            ['id' => 1],
            $data
        );

        return redirect()
            ->route('admin.profil-desa.index')
            ->with('success', 'Profil desa berhasil disimpan.');
    }
}