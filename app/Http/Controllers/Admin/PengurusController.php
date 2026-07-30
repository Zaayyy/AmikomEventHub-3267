<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Pengurus::with('jabatan');

        if ($search) {
            $query->where('name', 'LIKE', "%$search%");
        }

        $pengurus = $query->latest()->get();

        $jabatans = Jabatan::all();

        return view('admin.pengurus.index', compact('pengurus','jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan_id'=>'required',
            'name'=>'required|max:100',
            'description'=>'required|max:255',
            'salary'=>'required|numeric'
        ]);

        Pengurus::create([
            'jabatan_id'=>$request->jabatan_id,
            'name'=>$request->name,
            'description'=>$request->description,
            'salary'=>$request->salary,
            'created_by'=>'admin'
        ]);

        return redirect()->route('admin.pengurus.index')
                ->with('success','Pengurus berhasil ditambahkan!');
    }

    public function update(Request $request, Pengurus $penguru)
    {
        $request->validate([
            'jabatan_id'=>'required',
            'name'=>'required|max:100',
            'description'=>'required|max:255',
            'salary'=>'required|numeric'
        ]);

        $penguru->update([
            'jabatan_id'=>$request->jabatan_id,
            'name'=>$request->name,
            'description'=>$request->description,
            'salary'=>$request->salary,
            'updated_by'=>'admin'
        ]);

        return redirect()->route('admin.pengurus.index')
                ->with('success','Pengurus berhasil diupdate!');
    }

    public function destroy(Pengurus $penguru)
    {
        $penguru->delete();

        return redirect()->route('admin.pengurus.index')
                ->with('success','Pengurus berhasil dihapus!');
    }
}