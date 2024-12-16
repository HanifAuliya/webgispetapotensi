<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    // Menampilkan form input kategori
    public function create()
    {
        // Ambil semua kategori dari database
        $categories = Category::all();

        // Kirim data kategori ke view
        return view('category.create', compact('categories'));
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $iconPath = null;

        // Simpan file icon jika ada
        if ($request->hasFile('icon')) {
            // Format nama file: nama-category-icon.png
            $fileName = strtolower(str_replace(' ', '-', $request->name)) . '-icon.' . $request->file('icon')->getClientOriginalExtension();

            // Simpan file dengan nama kustom di folder icons
            $iconPath = $request->file('icon')->storeAs('icons', $fileName, 'public');
        }
        // Simpan kategori ke database
        Category::create([
            'name' => $request->name,
            'icon' => $iconPath, // Simpan path icon
        ]);

        return redirect()->route('category.create')->with('success', 'Kategori berhasil ditambahkan.');
    }
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Hapus file icon jika ada
        if ($category->icon && Storage::exists("public/{$category->icon}")) {
            Storage::delete("public/{$category->icon}");
        }

        $category->delete();

        return redirect()->route('category.create')->with('success', 'Kategori berhasil dihapus.');
    }
}
