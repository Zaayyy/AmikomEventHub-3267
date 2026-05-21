@extends('layouts.app')

@section('content')
<div class="container mx-auto p-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <div>
            {{-- Bagian untuk menampilkan Poster --}}
            @if($event->poster_path)
                <img src="{{ asset('storage/' . $event->poster_path) }}" class="w-full rounded-3xl shadow-lg">
            @else
                <div class="w-full h-96 bg-slate-200 rounded-3xl flex items-center justify-center">
                    <p class="text-slate-500 font-bold">Poster Belum Tersedia</p>
                </div>
            @endif
        </div>
        <div>
            <h1 class="text-4xl font-black mb-4">{{ $event->title }}</h1>
            <p class="text-indigo-600 font-bold mb-6">{{ $event->category->name }}</p>
            <div class="prose max-w-none text-slate-600">
                {{ $event->description }}
            </div>
            <div class="mt-10 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                <p class="font-bold text-sm text-slate-400 uppercase mb-2">Harga Tiket</p>
                <p class="text-3xl font-black text-slate-900">Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                <button class="w-full mt-6 bg-indigo-600 text-white py-4 rounded-xl font-bold hover:bg-indigo-700 transition">
                    Beli Tiket Sekarang
                </button>
            </div>
        </div>
    </div>
</div>
@endsection