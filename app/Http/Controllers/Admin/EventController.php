<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * READ: Menampilkan daftar event di tabel admin (Halaman 33-34 Modul)
     */
    public function index()
    {
        // Mengambil data event beserta kategorinya, diurutkan dari yang terbaru
        $events = Event::with('category')->latest()->paginate(10);
        
        return view('admin.events.index', compact('events'));
    }

    /**
     * CREATE (Form): Menampilkan form tambah event (Halaman 41 Modul)
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    /**
     * CREATE (Process): Menyimpan data event baru ke database (Halaman 41-42 Modul)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|numeric|min:0',
            'poster'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Logika sederhana simpan data (Poster path diset null dulu sesuai modul awal)
        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Data Event berhasil ditambahkan.');
    }

    /**
     * UPDATE (Form): Menampilkan form edit dengan data lama (Halaman 48 Modul)
     */
    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    /**
     * UPDATE (Process): Menyimpan perubahan data ke database (Halaman 48-49 Modul)
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|numeric|min:0',
        ]);

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Rincian data event berhasil diperbarui.');
    }

    /**
     * DELETE: Menghapus data dari database (Halaman 46-47 Modul)
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Data event berhasil dihapus secara permanen.');
    }
}