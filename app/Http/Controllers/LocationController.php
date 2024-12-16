<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;




class LocationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', ''); // Menangkap input pencarian
        $categoryFilter = $request->get('category_filter', ''); // Menangkap filter kategori

        // Query dengan filter kategori dan pencarian
        $locations = Location::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('agency', 'like', "%{$search}%")
                    ->orWhere('additional_info', 'like', "%{$search}%");
            })
            ->when($categoryFilter, function ($query) use ($categoryFilter) {
                $query->where('category_id', $categoryFilter);
            })
            ->paginate(10)
            ->withQueryString(); // Menjaga parameter query dalam pagination

        // Ambil semua kategori untuk dropdown
        $categories = Category::all();

        return view('dashboard', compact('locations', 'categories', 'search', 'categoryFilter'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('location.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Validasi relasi
            'coords' => 'required|string|regex:/^-?\d{1,2}\.\d+,\s*-?\d{1,3}\.\d+$/',
            'description' => 'required|string',
            'agency' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_info' => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $coords = array_map('floatval', explode(',', $request->coords));

        Location::create([
            'name' => $request->name,
            'category_id' => $request->category_id, // Simpan category_id
            'coords' => json_encode($coords),
            'description' => $request->description,
            'agency' => $request->agency,
            'image' => $imagePath,
            'additional_info' => $request->additional_info,
        ]);

        return redirect()->route('dashboard')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);

        $categories = Category::all();

        // Konversi koordinat dari JSON ke format string
        $location->coords = implode(',', json_decode($location->coords, true));


        return view('location.edit', compact('location', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'coords' => 'required|regex:/^-?\d{1,2}\.\d+,-?\d{1,3}\.\d+$/', // Validasi koordinat
        ]);

        try {
            $location = Location::findOrFail($id);

            if ($request->filled('coords')) {
                $coordsArray = explode(',', $request->coords);
                if (count($coordsArray) == 2) {
                    $coords = json_encode(array_map('floatval', $coordsArray));
                } else {
                    return redirect()->back()->withErrors(['coords' => 'Format koordinat tidak valid.']);
                }
            } else {
                return redirect()->back()->withErrors(['coords' => 'Koordinat harus diisi.']);
            }


            if ($request->hasFile('image')) {
                // Cek dan hapus gambar lama
                if ($location->image) {
                    $oldImagePath = $location->image;
                    if (Storage::exists($oldImagePath)) {
                        $deleted = Storage::delete($oldImagePath);
                        Log::info('Gambar lama berhasil dihapus.', ['path' => $oldImagePath, 'status' => $deleted ? 'Berhasil' : 'Gagal']);
                    } else {
                        Log::warning('Gambar lama tidak ditemukan.', ['path' => $oldImagePath]);
                    }
                }

                // Simpan gambar baru
                $imagePath = $request->file('image')->store('images', 'public');
                $location->image = $imagePath;
            }

            // Update lokasi
            $location->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'coords' => $coords,
                'description' => $request->description,
                'agency' => $request->agency,
                'additional_info' => $request->additional_info,
            ]);

            return redirect()->route('dashboard')->with('success', 'Lokasi berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error('Gagal mengupdate lokasi', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat mengupdate lokasi.']);
        }
    }


    public function destroy($id)
    {
        $location = Location::findOrFail($id);

        // Hapus file gambar jika ada
        if ($location->image) {
            Storage::disk('public')->delete($location->image);
        }

        // Hapus data lokasi
        $location->delete();

        return redirect()->route('dashboard')->with('success', 'Lokasi berhasil dihapus.');
    }
}
