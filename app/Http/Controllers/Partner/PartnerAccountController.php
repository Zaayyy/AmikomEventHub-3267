<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PartnerAccountController extends Controller
{
    /**
     * Tampilkan form edit akun (email & password) milik partner yang login.
     */
    public function edit()
    {
        $user = Auth::user();

        return view('partner.account.edit', compact('user'));
    }

    /**
     * Simpan perubahan email dan/atau password partner.
     * Password baru bersifat opsional: hanya diproses jika diisi.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'current_password' => ['required'],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Masukkan password saat ini untuk konfirmasi perubahan.',
        ]);

        // Password saat ini wajib benar sebelum perubahan apapun disimpan.
        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini yang Anda masukkan salah.'])
                ->onlyInput('email');
        }

        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = $request->password; // otomatis ter-hash lewat cast 'hashed' pada model User
        }

        $user->save();

        return back()->with('success', 'Akun berhasil diperbarui.');
    }
}