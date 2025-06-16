<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    public function index()
    {
        $props['title'] = 'Manage Menus';
        $props['menus'] = Menu::latest()->get();
        return view('admin.menu.index', $props);
    }

    public function create()
    {
        $props['title'] = 'Add New Menu';
        return view('admin.menu.create', $props);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:menus,name',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.menu.create')
                ->withErrors($validator)
                ->withInput();
        }

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('assets'), $imageName);

        Menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imageName,
            'stock' => $request->stock,
        ]);

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:menus,name,' . $menu->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.menu.edit', $menu->id)
                ->withErrors($validator)
                ->withInput();
        }

        $menuData = $request->only(['name', 'price', 'stock']);

        if ($request->hasFile('image')) {
            $oldImagePath = public_path('assets/' . $menu->image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets'), $imageName);
            $menuData['image'] = $imageName;
        }

        $menu->update($menuData);

        return redirect()->route('admin.menu.index')->with('success', 'Menu successfully updated!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->orderDetails()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Menu ini tidak dapat dihapus karena sudah menjadi bagian dari riwayat pesanan. Anda bisa mengedit stoknya menjadi 0 jika tidak ingin menampilkannya lagi.'
            ], 409);
        }

        if ($menu->image && File::exists(public_path('assets/' . $menu->image))) {
            File::delete(public_path('assets/' . $menu->image));
        }

        $menu->delete();

        return response()->json(['success' => true, 'message' => 'Menu berhasil dihapus!']);
    }
}
