@extends('layouts.partner')

@section('page_title', 'Edit Akun')
@section('page_subtitle', 'Kelola email dan password akun Anda')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold text-sm">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 text-sm">
        <p class="font-bold mb-1">Terdapat kesalahan:</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-2xl bg-white rounded-2xl border border-slate-100 shadow-sm p-8">

    <div class="flex items-center gap-4 mb-8 pb-8 border-b border-slate-100">
        <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center font-bold text-xl">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <p class="font-bold text-slate-800">{{ $user->name }}</p>
            <p class="text-sm text-slate-400">{{ $user->partner->name ?? 'Partner' }}</p>
        </div>
    </div>

    <form action="{{ route('partner.account.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
            <input type="email"
                   name="email"
                   value="{{ old('email', $user->email) }}"
                   required
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
        </div>

        <hr class="border-slate-100">

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Password Baru</label>
            <input type="password"
                   name="password"
                   placeholder="Kosongkan jika tidak ingin mengubah password"
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            <p class="text-xs text-slate-400 mt-1.5">Minimal 8 karakter. Kosongkan jika tidak ingin mengganti password.</p>
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password Baru</label>
            <input type="password"
                   name="password_confirmation"
                   placeholder="Ulangi password baru"
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
        </div>

        <hr class="border-slate-100">

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">
                Password Saat Ini <span class="text-red-500">*</span>
            </label>
            <input type="password"
                   name="current_password"
                   required
                   placeholder="Wajib diisi untuk konfirmasi perubahan"
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection