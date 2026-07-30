<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PartnerEventController extends Controller
{
    /**
     * Daftar event milik partner yang sedang login.
     */
    public function index()
    {
        $events = $this->partner()
            ->events()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('partner.events.index', compact('events'));
    }

    /**
     * Form tambah event baru.
     */
    public function create()
    {
        $categories = Category::all();

        return view('partner.events.create', compact('categories'));
    }

    /**
     * Simpan event baru — partner_id selalu dipaksa ke partner yang login,
     * partner tidak pernah bisa memilih/mengubah nilai ini.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        unset($data['poster']);

        if ($request->hasFile('poster')) {
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $data['partner_id'] = $this->partner()->id;

        Event::create($data);

        return redirect()->route('partner.events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Form edit event.
     */
    public function edit(Event $event)
    {
        $this->authorizeOwnership($event);

        $categories = Category::all();

        return view('partner.events.edit', compact('event', 'categories'));
    }

    /**
     * Perbarui event — hanya jika event ini benar milik partner yang login.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorizeOwnership($event);

        $data = $request->validate($this->rules(), $this->messages());

        unset($data['poster']);

        if ($request->hasFile('poster')) {
            if ($event->poster_path) {
                Storage::disk('public')->delete($event->poster_path);
            }

            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        // partner_id tidak pernah ikut divalidasi/diubah lewat form partner,
        // jadi tetap dikunci ke partner pemilik aslinya.
        $data['partner_id'] = $this->partner()->id;

        $event->update($data);

        return redirect()->route('partner.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Hapus event — hanya jika event ini benar milik partner yang login.
     */
    public function destroy(Event $event)
    {
        $this->authorizeOwnership($event);

        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
        }

        $event->delete();

        return redirect()->route('partner.events.index')->with('success', 'Event berhasil dihapus.');
    }

    /**
     * Partner yang sedang login.
     */
    private function partner()
    {
        return Auth::user()->partner;
    }

    /**
     * Pastikan event yang diakses benar-benar milik partner yang login.
     * Mencegah partner A mengedit/menghapus event milik partner B lewat URL manual.
     */
    private function authorizeOwnership(Event $event): void
    {
        if ((int) $event->partner_id !== (int) $this->partner()->id) {
            abort(403, 'Event ini bukan milik Anda.');
        }
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