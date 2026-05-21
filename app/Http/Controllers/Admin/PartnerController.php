<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    // READ: Menampilkan halaman utama & pencarian partner
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $partners = Partner::where('name', 'LIKE', '%' . $search . '%')
                ->latest()
                ->get();
        } else {
            $partners = Partner::latest()->get();
        }

        return view('admin.partners.index', compact('partners'));
    }

    // CREATE: Menyimpan nama dan URL logo partner langsung ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'required|url|max:255' // PERBAIKAN: Validasi tipe URL string
        ]);

        Partner::create([
            'name' => $request->name,
            'logo_url' => $request->logo_url
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner baru berhasil ditambahkan!');
    }

    // UPDATE: Memperbarui nama atau URL logo partner
    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'required|url|max:255' // PERBAIKAN: Validasi tipe URL string
        ]);

        $partner->update([
            'name' => $request->name,
            'logo_url' => $request->logo_url
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Data partner berhasil diperbarui!');
    }

    // DELETE: Langsung hapus dari database tanpa perlu unlink file storage
    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus!');
    }
}