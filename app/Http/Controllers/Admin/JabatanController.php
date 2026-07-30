<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    // READ
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $jabatans = Jabatan::where('name', 'LIKE', '%' . $search . '%')
                ->latest()
                ->get();
        } else {
            $jabatans = Jabatan::latest()->get();
        }

        return view('admin.jabatans.index', compact('jabatans'));
    }

    // CREATE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:jabatans,name',
        ]);

        Jabatan::create([
            'name' => $request->name,
            'created_by' => 'admin',
        ]);

        return redirect()->route('admin.jabatans.index')
            ->with('success', 'Jabatan berhasil ditambahkan!');
    }

    // UPDATE
    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:jabatans,name,' . $jabatan->id,
        ]);

        $jabatan->update([
            'name' => $request->name,
            'updated_by' => 'admin',
        ]);

        return redirect()->route('admin.jabatans.index')
            ->with('success', 'Jabatan berhasil diperbarui!');
    }

    // DELETE
    public function destroy(Jabatan $jabatan)
    {
        if ($jabatan->pengurus()->count() > 0) {
            return redirect()->route('admin.jabatans.index')
                ->with('error', 'Jabatan masih digunakan oleh pengurus.');
        }

        $jabatan->delete();

        return redirect()->route('admin.jabatans.index')
            ->with('success', 'Jabatan berhasil dihapus!');
    }
}