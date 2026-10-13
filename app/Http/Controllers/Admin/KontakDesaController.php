<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontakDesa;
use Illuminate\Http\Request;

class KontakDesaController extends Controller
{
    public function index()
    {
        $kontak = KontakDesa::find(1);

        return view('admin.kontak-desa.index', compact('kontak'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'alamat' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'string', 'max:255'],
            'jam_pelayanan' => ['required', 'string'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'radius_meter' => ['required', 'integer', 'min:1'],
        ]);

        KontakDesa::updateOrCreate(
            ['id' => 1],
            $data
        );

        return redirect()
            ->route('admin.kontak-desa.index')
            ->with('success', 'Kontak desa berhasil disimpan.');
    }
}