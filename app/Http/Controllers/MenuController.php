<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    /**
     * Menampilkan daftar semua menu.
     */
    public function index()
    {
        $props['title'] = 'Manage Menus';
        $props['menus'] = Menu::all();
        return view('admin.menu.index', $props);
    }

    /**
     * Menampilkan formulir untuk membuat menu baru.
     */
    public function create()
    {
        $props['title'] = 'Add New Menu';
        return view('admin.menu.create', $props);
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0', // Tambahkan validasi untuk stock
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.menu.create')
                ->withErrors($validator)
                ->withInput();
        }

        // 2. Proses upload gambar (tidak berubah)
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('assets'), $imageName);

        // 3. Simpan data ke database
        Menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imageName,
            'stock' => $request->stock, // Tambahkan 'stock' di sini
        ]);

        // 4. Redirect ke halaman daftar menu dengan pesan sukses
        return redirect()->route('admin.menu.index')->with('success', 'Menu successfully added!');
    }

    public function edit(Menu $menu)
    {
        $props['title'] = 'Edit Menu';
        $props['menu'] = $menu;
        return view('admin.menu.edit', $props);
    }

    public function update(Request $request, Menu $menu)
    {
        // 1. Validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image tidak wajib diisi saat edit
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.menu.edit', $menu->id)
                ->withErrors($validator)
                ->withInput();
        }

        $menuData = $request->only(['name', 'price', 'stock']);

        // 2. Cek jika ada gambar baru yang di-upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            $oldImagePath = public_path('assets/' . $menu->image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            // Upload gambar baru
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets'), $imageName);
            $menuData['image'] = $imageName;
        }

        // 3. Update data di database
        $menu->update($menuData);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('admin.menu.index')->with('success', 'Menu successfully updated!');
    }

    public function destroy(Menu $menu)
    {
        // 1. Hapus file gambar yang ada
        $imagePath = public_path('assets/' . $menu->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // 2. Hapus data dari database
        $menu->delete();

        // 3. Kembalikan response JSON
        return response()->json(['success' => true, 'message' => 'Menu deleted successfully.']);
    }
}
