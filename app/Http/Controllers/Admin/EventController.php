<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    //mengambil data event beserta data kategori yang berelasi
    public function index()
    {
        $events = Event::with('category')->latest()->paginate(10);
        
        return view('admin.events.index', compact('events'));
    }

    /**
     * CREATE (Form): Menampilkan form tambah event 
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    /**
     * CREATE (Process): Menyimpan data event baru ke database 
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        unset($data['poster']);

        if ($request->hasFile('poster')) {
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Data Event berhasil ditambahkan.');
    }

    /**
     * UPDATE (Form): Menampilkan form edit dengan data lama 
     */
    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    /**
     * UPDATE (Process): Menyimpan perubahan data ke database 
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->validate($this->rules(), $this->messages());

        unset($data['poster']);

        if ($request->hasFile('poster')) {
            if ($event->poster_path) {
                Storage::disk('public')->delete($event->poster_path);
            }

            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Rincian data event berhasil diperbarui.');
    }

    /**
     * DELETE: Menghapus data dari database 
     */
    public function destroy(Event $event)
    {
        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Data event berhasil dihapus secara permanen.');
    }

    private function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:1',
            'poster'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    private function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori tidak valid.',
            'title.required'       => 'Judul event wajib diisi.',
            'title.max'            => 'Judul event maksimal 255 karakter.',
            'date.required'        => 'Tanggal event wajib diisi.',
            'date.date'            => 'Format tanggal event tidak valid.',
            'location.required'    => 'Lokasi event wajib diisi.',
            'price.required'       => 'Harga tiket wajib diisi.',
            'price.numeric'        => 'Harga tiket harus berupa angka.',
            'price.min'            => 'Harga tiket tidak boleh kurang dari 0.',
            'stock.required'       => 'Stok tiket wajib diisi.',
            'stock.integer'        => 'Stok tiket harus berupa bilangan bulat.',
            'stock.min'            => 'Stok tiket minimal 1.',
            'poster.image'         => 'Poster harus berupa file gambar.',
            'poster.mimes'         => 'Poster harus berformat jpg, jpeg, png, atau webp.',
            'poster.max'           => 'Ukuran poster maksimal 2 MB.',
        ];
    }
}
