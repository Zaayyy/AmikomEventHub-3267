<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $partners = Partner::with(['events', 'user'])
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        return view('admin.partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'logo_url' => 'required',
            'description' => 'nullable',

            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $partner = Partner::create([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
            'description' => $request->description,
        ]);

        User::create([
            'name' => $partner->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            'role' => 'partner',

            'partner_id' => $partner->id,
        ]);
        

        return back()->with('success', 'Partner berhasil ditambahkan.');
    }
        public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|max:255',
            'logo_url' => 'required',
            'description' => 'nullable',

            'email' => 'required|email|unique:users,email,' . optional($partner->user)->id,
            'password' => 'nullable|min:8',
        ]);

        $partner->update([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
            'description' => $request->description,
        ]);

        if ($partner->user) {

            $partner->user->name = $partner->name;
            $partner->user->email = $request->email;

            if ($request->filled('password')) {
                $partner->user->password = Hash::make($request->password);
            }

            $partner->user->save();

        } else {

            User::create([
                'name' => $partner->name,
                'email' => $request->email,
                'password' => Hash::make($request->password ?? 'password123'),

                'role' => 'partner',

                'partner_id' => $partner->id,
            ]);

        }

        return back()->with('success', 'Partner berhasil diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->user) {
            $partner->user->delete();
        }

        $partner->delete();

        return back()->with('success', 'Partner berhasil dihapus.');
    }
}