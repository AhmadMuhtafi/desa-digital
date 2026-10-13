<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('parent')
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        $parentMenus = Menu::whereNull('parent_id')
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        return view('admin.menu.index', compact(
            'menus',
            'parentMenus'
        ));
    }

    public function create()
    {
        $parentMenus = Menu::whereNull('parent_id')
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        return view('admin.menu.create', compact('parentMenus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('menu', 'id'),
            ],
            'label' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'urutan' => ['required', 'integer', 'min:0', 'max:32767'],
            'is_active' => ['required', 'boolean'],
        ]);

        Menu::create($data);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $parentMenus = Menu::whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        return view('admin.menu.edit', compact(
            'menu',
            'parentMenus'
        ));
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('menu', 'id'),
            ],
            'label' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'urutan' => ['required', 'integer', 'min:0', 'max:32767'],
            'is_active' => ['required', 'boolean'],
        ]);

        if (
            $data['parent_id'] !== null &&
            (
                (int) $data['parent_id'] === (int) $menu->id ||
                $menu->children()->where(
                    'id',
                    $data['parent_id']
                )->exists()
            )
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'parent_id' => 'Menu tidak dapat menjadi induk bagi dirinya sendiri atau submenu langsungnya.',
                ]);
        }

        $menu->update($data);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->children()->exists()) {
            return redirect()
                ->route('admin.menu.index')
                ->with(
                    'error',
                    'Menu tidak dapat dihapus karena masih memiliki submenu. Hapus atau pindahkan submenu terlebih dahulu.'
                );
        }

        $menu->delete();

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}