<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::orderBy('kunci')->get();

        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'pengaturan' => ['required', 'array'],
            'pengaturan.*' => ['nullable', 'string'],
        ]);

        foreach ($data['pengaturan'] as $kunci => $nilai) {
            Pengaturan::updateOrCreate(
                ['kunci' => $kunci],
                ['nilai' => $nilai ?? '']
            );
        }

        return redirect()
            ->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan website berhasil disimpan.');
    }
}