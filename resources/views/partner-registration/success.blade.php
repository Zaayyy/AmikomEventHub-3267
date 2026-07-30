@extends('layouts.app')

@section('title', 'Pengajuan Terkirim')

@section('content')
<section class="max-w-2xl mx-auto px-6 py-20">
    <div class="bg-white border border-slate-100 rounded-[2rem] shadow-sm p-10 md:p-14 text-center">

        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-3">
            Pengajuan Berhasil Dikirim
        </h1>

        <p class="text-slate-500 leading-relaxed mb-8 max-w-md mx-auto">
            Terima kasih telah mendaftarkan organisasi Anda. Tim kami akan
            meninjau kelengkapan dokumen dan proposal yang Anda kirimkan.
        </p>

        <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-50 text-amber-700 rounded-full text-xs font-bold uppercase tracking-wide mb-10">
            <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
            Menunggu Persetujuan Admin
        </div>

        {{-- Timeline langkah selanjutnya --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10 text-left">
            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                <p class="text-xs font-bold text-indigo-600 mb-1">Langkah 1</p>
                <p class="text-sm font-bold text-slate-800 mb-1">Verifikasi Data</p>
                <p class="text-xs text-slate-500 leading-relaxed">Tim kami memeriksa kelengkapan dan keaslian dokumen.</p>
            </div>
            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                <p class="text-xs font-bold text-indigo-600 mb-1">Langkah 2</p>
                <p class="text-sm font-bold text-slate-800 mb-1">Notifikasi Email</p>
                <p class="text-xs text-slate-500 leading-relaxed">Hasil review dikirim ke email yang Anda daftarkan.</p>
            </div>
            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                <p class="text-xs font-bold text-indigo-600 mb-1">Langkah 3</p>
                <p class="text-sm font-bold text-slate-800 mb-1">Tampil di Partner</p>
                <p class="text-xs text-slate-500 leading-relaxed">Setelah disetujui, logo organisasi tampil di beranda.</p>
            </div>
        </div>

        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-2 px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:scale-105 transition-transform">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Kembali ke Home
        </a>
    </div>
</section>
@endsection