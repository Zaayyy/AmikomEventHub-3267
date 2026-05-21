<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // PERBAIKAN: Import library Str untuk membuat slug

class CategoryController extends Controller
{
    // READ: Menampilkan halaman utama & daftar tabel kategori (Lengkap dengan Fitur Pencarian)
    public function index(Request $request)
    {
        // Ambil keyword pencarian dari input bernama 'search'
        $search = $request->input('search');

        // Jika ada kata kunci pencarian, seleksi dengan clause LIKE
        if ($search) {
            $categories = Category::where('name', 'LIKE', '%' . $search . '%')
                ->latest()
                ->get();
        } else {
            $categories = Category::latest()->get();
        }

        return view('admin.categories.index', compact('categories'));
    }

    // CREATE: Menyimpan data kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // PERBAIKAN: Ikut sertakan kolom 'slug' saat membuat kategori baru
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) 
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    // UPDATE: Memperbarui nama kategori
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        // PERBAIKAN: Ikut sertakan kolom 'slug' saat memperbarui kategori
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // DELETE: Menghapus data kategori
    public function destroy(Category $category)
    {
        // Proteksi jika kategori masih terikat dengan event
        if ($category->events()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Gagal menghapus! Kategori ini masih digunakan oleh beberapa event.');
        }

        $category->delete();
        
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}