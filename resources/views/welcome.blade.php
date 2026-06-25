@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
    <div class="flex-1 space-y-8">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">Platform Event Kampus</span>
        <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
            Temukan & Ikuti <span class="text-indigo-600">Event Kampus</span> Inspiratif.
        </h1>
        <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
            Mulai dari seminar, workshop, hingga sharing session seputar dunia perkuliahan dan teknologi, semua bisa kamu akses dengan mudah di sini.
        </p>
        <div class="flex gap-4">
            <a href="#events" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                Mulai Jelajah
            </a>
            <a href="#" class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                Cara Pesan
            </a>
        </div>
    </div>
    <div class="flex-1 relative">
        <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        
        @php
            $closestEvent = $events->first();
            $dummyImage = 'https://placehold.co/800x1000/e2e8f0/94a3b8?text=Poster+Belum+Tersedia';
            $heroImage = $closestEvent && $closestEvent->poster_path ? asset('storage/' . $closestEvent->poster_path) : $dummyImage;
        @endphp
        
        <div class="relative overflow-hidden aspect-[3/4]">
    <img src="{{ ($closestEvent && $closestEvent->poster_path && \Storage::disk('public')->exists($closestEvent->poster_path)) ? asset('storage/' . $closestEvent->poster_path) : 'https://placehold.co/400x600?text=Hero+Poster' }}" 
         alt="{{ $closestEvent->title ?? 'Poster Event' }}" 
         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
</div>

        <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                    <p class="font-bold">Pembayaran Aman via Midtrans</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="events" class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex flex-col items-center text-center mb-12">
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold mb-2 text-slate-900">Event Terdekat</h2>
            <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
        </div>

        {{-- Filter Kategori --}}
        <div class="inline-flex flex-wrap items-center justify-center gap-2 p-1.5 bg-slate-50 rounded-2xl border border-slate-200">
            <a href="{{ route('home') }}" 
               class="px-6 py-2.5 rounded-xl font-bold text-xs transition-all duration-300
               {{ !request('category') 
                  ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-slate-200' 
                  : 'text-slate-500 hover:text-indigo-600 hover:bg-white/50' }}">
                Semua Event
            </a>

            @foreach($categories as $cat)
                <a href="{{ route('home', ['category' => $cat->id]) }}" 
                   class="px-6 py-2.5 rounded-xl font-bold text-xs transition-all duration-300
                   {{ request('category') == $cat->id 
                      ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-slate-200' 
                      : 'text-slate-500 hover:text-indigo-600 hover:bg-white/50' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
            <div class="group bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden flex flex-col active:scale-[0.98]">
                
                {{-- Poster Area --}}
                <div class="relative overflow-hidden aspect-video">
                    <img src="{{ $event->poster_path ? asset('storage/' . $event->poster_path) : 'https://placehold.co/600x400/f1f5f9/94a3b8?text=Poster+Event' }}" 
                         alt="{{ $event->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    
                    <div class="absolute top-4 left-4 px-3 py-1 bg-indigo-600 text-white rounded-lg text-[10px] font-bold uppercase shadow-lg">
                        {{ $event->category->name }}
                    </div>
                </div>
                
                {{-- Content Area --}}
                <div class="p-8 flex-1 flex flex-col">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-slate-800 mb-3 leading-snug group-hover:text-indigo-600 transition line-clamp-2">
                            {{ $event->title }}
                        </h3>
                        
                        <div class="flex items-center gap-2 text-slate-400 text-xs font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ $event->date->format('d F Y') }}</span>
                        </div>
                    </div>
                    
                    {{-- Harga & Button --}}
                    <div class="mt-auto flex justify-between items-center pt-4">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Harga Tiket</span>
                            <span class="text-2xl font-black text-slate-900 tracking-tight">
                                Rp{{ number_format($event->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <a href="{{ route('events.show', $event->id) }}" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-md shadow-indigo-100 text-xs active:scale-90">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200 text-slate-400 font-medium">
                Belum ada event tersedia di kategori ini.
            </div>
        @endforelse
    </div>
</section>

<section class="bg-slate-50 py-20 mt-16 w-full">
    <div class="max-w-6xl mx-auto px-6 text-center">

        <!-- Heading -->
        <span class="inline-block text-xs font-bold tracking-[0.25em] text-indigo-600 uppercase mb-3">
            Official Partners
        </span>

        <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-4">
            Didukung Oleh Mitra Terbaik
        </h2>

        <p class="text-slate-500 max-w-2xl mx-auto mb-12">
            Berbagai perusahaan dan komunitas terpercaya yang mendukung
            keberlangsungan event di AmikomEventHub.
        </p>

        <!-- Partner Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">

            @forelse($partners as $partner)

                <div 
                    class="group bg-white rounded-2xl shadow-sm border border-slate-100 
                           hover:shadow-xl hover:-translate-y-1 transition-all duration-300 
                           p-6 flex items-center justify-center h-36"
                    title="{{ $partner->name }}"
                >

                    <img 
                        src="{{ $partner->logo_url }}"
                        alt="Logo {{ $partner->name }}"
                        class="max-h-16 max-w-full object-contain 
                               grayscale opacity-80 
                               group-hover:grayscale-0 group-hover:opacity-100 
                               transition duration-300"
                    >

                </div>

            @empty

                <div class="col-span-full">
                    <p class="text-slate-400 text-sm italic">
                        AmikomEventHub membuka peluang kemitraan dan sponsorship event.
                    </p>
                </div>

            @endforelse

        </div>

    </div>
</section>

<footer class="w-full bg-slate-900 text-slate-300 py-10">
    <div class="max-w-7xl mx-auto px-6 text-center text-sm">
        <p>🎓 Aplikasi ini sekedar untuk bahan demo materi matakuliah <strong>Digital Bisnis</strong> di <strong>Universitas Amikom Yogyakarta</strong>.</p>
        <p class="text-slate-500 mt-2">Demo Purpose Only &bull; 2026</p>
    </div>
</footer>
@endsection