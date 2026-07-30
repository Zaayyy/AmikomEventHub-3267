<?php

namespace App\Http\Controllers;

use App\Models\PartnerRegistration;
use Illuminate\Http\Request;

class PartnerRegistrationController extends Controller
{
    public function create()
    {
        return view('partner-registration.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'organization_name' => 'required|max:255',
            'organization_type' => 'required|max:100',
            'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|email',
            'phone' => 'required|max:20',
            'address' => 'required',
            'description' => 'required',
            'proposal' => 'required|mimes:pdf|max:5120',
        ]);

        $logo = $request->file('logo')->store('partner-logo', 'public');

        $proposal = $request->file('proposal')->store('partner-proposal', 'public');

        PartnerRegistration::create([

            'organization_name' => $request->organization_name,

            'organization_type' => $request->organization_type,

            'logo' => $logo,

            'email' => $request->email,

            'phone' => $request->phone,

            'address' => $request->address,

            'description' => $request->description,

            'proposal' => $proposal,

            'status' => 'pending'

        ]);

        return redirect()->route('partner-registration.success');
    }

    public function success()
    {
        return view('partner-registration.success');
    }
}