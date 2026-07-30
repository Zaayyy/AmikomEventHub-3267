@extends('layouts.admin')

@section('page_title', 'Detail Pengajuan Partner')
@section('page_subtitle', $registration->organization_name)

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.partner-registrations.index') }}"
       class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-indigo-600 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Daftar Pengajuan
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Kolom Kiri: Detail Data --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-8">

        <div class="flex items-center gap-4 mb-8">
            <img src="{{ asset('storage/'.$registration->logo) }}"
                 alt="Logo {{ $registration->organization_name }}"
                 class="w-20 h-20 rounded-2xl object-contain border border-slate-100 p-2 bg-slate-50">
            <div>
                <h3 class="text-lg font-extrabold text-slate-900">{{ $registration->organization_name }}</h3>
                <p class="text-sm text-slate-500">{{ $registration->organization_type }}</p>
            </div>
        </div>

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
            <div>
                <dt class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Email</dt>
                <dd class="text-sm font-semibold text-slate-800">{{ $registration->email }}</dd>
            </div>
            <div>
                <dt class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">No. HP</dt>
                <dd class="text-sm font-semibold text-slate-800">{{ $registration->phone }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Alamat</dt>
                <dd class="text-sm font-semibold text-slate-800 leading-relaxed">{{ $registration->address }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Deskripsi Organisasi</dt>
                <dd class="text-sm text-slate-600 leading-relaxed">{{ $registration->description }}</dd>
            </div>
        </dl>

        <a href="{{ asset('storage/'.$registration->proposal) }}"
           target="_blank"
           class="inline-flex items-center gap-2 px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-200 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Download Proposal
        </a>
    </div>

    {{-- Kolom Kanan: Status & Aksi --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 h-fit">

        <h4 class="text-sm font-extrabold text-slate-900 uppercase tracking-wide mb-5">Status Pengajuan</h4>

        @if($registration->status == 'pending')

            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-bold mb-6">
                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Menunggu Review
            </div>

            <form method="POST"
                  action="{{ route('admin.partner-registrations.approve', $registration->id) }}"
                  onsubmit="return confirm('Setujui pengajuan ini sebagai partner resmi?');"
                  class="mb-4">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-green-600 text-white rounded-xl font-bold text-sm hover:bg-green-700 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Approve
                </button>
            </form>

            <form method="POST"
                  action="{{ route('admin.partner-registrations.reject', $registration->id) }}"
                  onsubmit="return confirm('Tolak pengajuan ini?');">
                @csrf
                <label class="block text-xs font-bold text-slate-500 mb-2">Alasan Penolakan</label>
                <textarea name="admin_note"
                          rows="3"
                          required
                          placeholder="Tuliskan alasan penolakan..."
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400 transition text-sm resize-none mb-3"></textarea>
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-red-500 text-white rounded-xl font-bold text-sm hover:bg-red-600 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Reject
                </button>
            </form>

        @elseif($registration->status == 'approved')

            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold mb-4">
                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Approved
            </div>
            <p class="text-sm text-slate-500 leading-relaxed">
                Organisasi ini sudah disetujui dan tampil sebagai official partner di halaman beranda.
            </p>

        @else

            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-bold mb-4">
                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Rejected
            </div>
            @if($registration->admin_note)
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Catatan Admin</p>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $registration->admin_note }}</p>
                </div>
            @endif

        @endif
    </div>
</div>

@endsection