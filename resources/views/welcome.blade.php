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
        <div class="flex gap-4 items-center flex-wrap">

    <a href="#events"
       class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
        Mulai Jelajah
    </a>

    @guest
        <a href="{{ route('google.redirect') }}"
   class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
    Login dengan Google
</a>
    @endguest

    @auth
        <div class="flex items-center gap-3 bg-white rounded-2xl px-4 py-2 shadow">

            @if(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}"
                     class="w-10 h-10 rounded-full"
                     alt="Avatar">
            @endif

            <div>
                <p class="font-bold text-slate-800">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-xs text-slate-500">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <form action="{{ route('user.logout') }}" method="POST">
                @csrf

                <button
                    class="ml-2 text-red-500 hover:text-red-700 font-semibold">
                    Logout
                </button>

            </form>

        </div>
    @endauth

</div>
    </div>
    <div class="flex-1 relative">
        <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        
        @php
            $closestEvent = $events->first();
            $eventPosters = [
                1 => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&q=80',
                2 => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80',
                3 => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=800&q=80',
                4 => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=800&q=80',
                5 => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=800&q=80',
                6 => 'https://images.unsplash.com/photo-1538481199705-c710c4e965fc?auto=format&fit=crop&w=800&q=80',
                7 => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=800&q=80',
                8 => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=800&q=80',
                9 => 'https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?auto=format&fit=crop&w=800&q=80',
            ];
            $heroImage = ($closestEvent && $closestEvent->poster_path && \Storage::disk('public')->exists($closestEvent->poster_path)) 
                ? asset('storage/' . $closestEvent->poster_path) 
                : ($closestEvent ? ($eventPosters[$closestEvent->id] ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80') : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80');
        @endphp
        
        <div class="relative overflow-hidden aspect-[3/4] rounded-3xl shadow-2xl border border-white/20 group">
            <img src="{{ $heroImage }}" 
                 alt="{{ $closestEvent->title ?? 'Poster Event' }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @if($closestEvent)
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent flex flex-col justify-end p-8 text-white">
                    <span class="px-3 py-1 bg-indigo-600 rounded-lg text-xs font-bold uppercase w-max mb-2 shadow-lg">Featured Event</span>
                    <h3 class="text-2xl font-bold leading-tight mb-1">{{ $closestEvent->title }}</h3>
                    <p class="text-xs text-slate-300 font-medium">{{ $closestEvent->date->format('d F Y') }}</p>
                </div>
            @endif
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
                    @php
                        $cardImage = ($event->poster_path && \Storage::disk('public')->exists($event->poster_path))
                            ? asset('storage/' . $event->poster_path)
                            : ($eventPosters[$event->id] ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=600&q=80');
                    @endphp
                    <img src="{{ $cardImage }}" 
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

        <p class="text-slate-500 max-w-2xl mx-auto mb-10">
            Berbagai perusahaan dan komunitas terpercaya yang mendukung
            keberlangsungan event di AmikomEventHub.
        </p>

        <div class="max-w-2xl mx-auto mb-12 bg-white border border-slate-100 rounded-[2rem] shadow-sm p-12 flex flex-col items-center text-center">

            <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>

            <h3 class="text-2xl font-extrabold text-slate-900 mb-3">
                Punya organisasi yang ingin bekerja sama dengan kami?
            </h3>

            <p class="text-slate-500 max-w-md mx-auto mb-8 leading-relaxed">
                Daftarkan organisasi Anda dan jadilah Official Partner AmikomEventHub.
                Proses pengajuan cepat dan akan direview langsung oleh tim kami.
            </p>

            <a href="{{ route('partner-registration.create') }}"
               class="inline-flex items-center gap-2 px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:scale-105 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Daftarkan Organisasi
            </a>

        </div>

        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8">
            Partner Kami Saat Ini
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

                    @php
                        $partnerLogos = [
                            'Universitas Amikom Yogyakarta' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSXzAOh5RU1VRgDxIzxvrpAIqy3Mp6xMfGqD9TyrvQBot_HiZkWVG9MoZ8&s=10',
                            'PT. Bank Central Asia' => 'https://images.seeklogo.com/logo-png/23/1/bca-bank-logo-png_seeklogo-232742.png',
                            'HIMASI' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTlI_fhJZkxmpRaXlBxy4mHdyB_DXIAYqlpUfD0OgypuYiUHbAdpQxRazzu&s=10',
                            'PT. PARAGON' => 'https://assets-a1.kompasiana.com/items/album/2025/06/22/paragon-6857a62aed6415524902f1c3.jpg',
                            'Google' => asset('assets/logos/google.svg'),
                            'Tokopedia' => asset('assets/logos/tokopedia.svg'),
                        ];

                        $partnerName = trim($partner->name);
                        $logoSrc = null;

                        foreach ($partnerLogos as $nameKey => $url) {
                            if (stripos($partnerName, $nameKey) !== false || stripos($nameKey, $partnerName) !== false) {
                                $logoSrc = $url;
                                break;
                            }
                        }

                        if (!$logoSrc) {
                            if (str_contains($partner->logo_url, '127.0.0.1') || str_contains($partner->logo_url, 'partner-logo')) {
                                $logoSrc = 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=300&q=80';
                            } else {
                                $logoSrc = $partner->logo_url;
                            }
                        }
                    @endphp

                    <img 
                        src="{{ $logoSrc }}"
                        alt="Logo {{ $partner->name }}"
                        class="max-h-16 max-w-full object-contain hover:scale-110 transition duration-300"
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
        <p>Aplikasi ini sekedar untuk bahan demo materi matakuliah <strong>Digital Bisnis</strong> di <strong>Universitas Amikom Yogyakarta</strong>.</p>
        <p class="text-slate-500 mt-2">Demo Purpose Only &bull; 2026</p>
    </div>
</footer>
@endsection