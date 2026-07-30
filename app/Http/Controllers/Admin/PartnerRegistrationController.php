<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\PartnerRegistration;
use Illuminate\Http\Request;

class PartnerRegistrationController extends Controller
{

    public function index()
    {
        $registrations = PartnerRegistration::latest()->get();

        return view(
            'admin.partner-registrations.index',
            compact('registrations')
        );
    }

    public function show(PartnerRegistration $registration)
    {
        return view(
            'admin.partner-registrations.show',
            compact('registration')
        );
    }

    public function approve(PartnerRegistration $registration)
{
    // Cek apakah pengajuan sudah pernah diproses
    if ($registration->status != 'pending') {
        return back()->with('error', 'Pengajuan sudah diproses.');
    }

    // Tambahkan ke tabel partners
    Partner::create([
        'name' => $registration->organization_name,
        'logo_url' => asset('storage/' . $registration->logo),
        'description' => $registration->description,
    ]);

    // Ubah status menjadi approved
    $registration->update([
        'status' => 'approved'
    ]);

    return redirect()
        ->route('admin.partner-registrations.index')
        ->with('success', 'Partner berhasil disetujui.');
}

    public function reject(Request $request, PartnerRegistration $registration)
{
    // Cek apakah pengajuan sudah diproses
    if ($registration->status != 'pending') {
        return back()->with('error', 'Pengajuan sudah diproses.');
    }

    $request->validate([
        'admin_note' => 'required'
    ]);

    $registration->update([
        'status' => 'rejected',
        'admin_note' => $request->admin_note
    ]);

    return redirect()
        ->route('admin.partner-registrations.index')
        ->with('success', 'Pengajuan ditolak.');
}

}