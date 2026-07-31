@extends('layouts.app')

@section('title', 'Detail Event ' . $event->title)

@section('content')

<style>
    /* Jarak antara poster dan konten kanan.
       Ditulis sebagai CSS murni (bukan hanya class Tailwind) supaya
       tetap tampil walau asset Tailwind belum di-build ulang. */
    .event-split {
        gap: 2.5rem;
    }

    .event-poster-col {
        width: 100%;
        max-width: 24rem;
        margin-left: auto;
        margin-right: auto;
    }

    /* Panel kanan: scrollbar tipis & rapi */
    .event-scroll-pane {
        scrollbar-width: thin;
        scrollbar-color: #c7d2fe transparent;
    }

    .event-scroll-pane::-webkit-scrollbar {
        width: 6px;
    }

    .event-scroll-pane::-webkit-scrollbar-track {
        background: transparent;
    }

    .event-scroll-pane::-webkit-scrollbar-thumb {
        background-color: #c7d2fe;
        border-radius: 9999px;
    }

    .event-scroll-pane::-webkit-scrollbar-thumb:hover {
        background-color: #a5b4fc;
    }

    /* Split-scroll layout hanya aktif di layar besar (lg ke atas).
       Di mobile, halaman tetap scroll normal seperti biasa. */
    @media (min-width: 1024px) {
        .event-split {
            align-items: flex-start;
            gap: 3rem;
            /* jarak poster <-> teks kanan */
        }

        .event-poster-col {
            width: 280px;
            max-width: none;
            margin-left: 0;
            flex-shrink: 0;
        }

        .event-poster-sticky {
            position: sticky;
            top: 7.5rem;
            /* selaras dengan nav sticky (top-8) + tinggi nav */
            max-height: calc(100vh - 9rem);
        }

        .event-poster-sticky img {
            max-height: calc(100vh - 9rem);
        }

        .event-scroll-pane {
            position: sticky;
            top: 7.5rem;
            max-height: calc(100vh - 9rem);
            overflow-y: auto;
            padding-left: 1rem;
            /* jarak tambahan di sisi kiri panel kanan */
        }
    }

    @media (min-width: 1280px) {
        .event-poster-col {
            width: 300px;
        }
    }
</style>

<main class="max-w-7xl mx-auto px-6 py-12">

    {{-- =====================================
        EVENT DETAIL
        Poster tetap diam (sticky) di kiri,
        konten di kanan punya scroll sendiri.
    ====================================== --}}
    <div class="event-split flex flex-col lg:flex-row gap-10 lg:gap-12">

        {{-- Poster (kiri, diam) --}}
        <div class="event-poster-col w-full max-w-sm mx-auto lg:mx-0 lg:w-[280px] xl:w-[300px] lg:shrink-0">
            <div class="event-poster-sticky">
                @php
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
                    $detailPoster = ($event->poster_path && \Storage::disk('public')->exists($event->poster_path))
                        ? asset('storage/' . $event->poster_path)
                        : ($eventPosters[$event->id] ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80');
                @endphp
                <img
                    src="{{ $detailPoster }}"
                    alt="Poster {{ $event->title }}"
                    class="w-full aspect-[3/4] object-cover rounded-3xl border-4 border-white shadow-xl"
                >
            </div>
        </div>

        {{-- Konten (kanan, scroll sendiri) --}}
        <div class="event-scroll-pane w-full lg:flex-1 space-y-8 lg:pr-4">

            {{-- Header --}}
            <div class="space-y-3">
                <span class="inline-block px-4 py-1.5 rounded-full bg-indigo-100 text-indigo-700 text-sm font-bold uppercase tracking-wider">
                    {{ $event->category->name ?? 'Update' }}
                </span>

                <h1 class="text-3xl md:text-4xl font-black leading-tight text-slate-900">
                    {{ $event->title }}
                </h1>

                @if ($event->partner)
                    <p class="text-slate-500 text-sm">
                        Diselenggarakan oleh
                        <span class="font-bold text-slate-700">{{ $event->partner->name }}</span>
                    </p>
                @endif

                <div class="flex flex-wrap gap-x-6 gap-y-2 text-slate-500 font-medium pt-1">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $event->date->translatedFormat('l, d M Y - H:i') }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $event->location }}</span>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="border-t border-slate-100 pt-6">
                <h3 class="text-xl font-bold text-slate-900 mb-3">Deskripsi Event</h3>
                <p class="text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $event->description }}
                </p>
            </div>

            {{-- Ticket Card --}}
            <div class="relative overflow-hidden rounded-3xl bg-indigo-600 p-6 md:p-8 text-white shadow-xl">

                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">

                    <div>
                        <p class="text-indigo-200 font-bold uppercase tracking-widest text-xs mb-2">
                            Harga Tiket
                        </p>

                        <h2 class="text-3xl md:text-4xl font-black">
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                            <span class="text-base font-medium text-indigo-200">/ orang</span>
                        </h2>

                        <p class="mt-3 flex items-center justify-center md:justify-start gap-2 text-indigo-100 text-sm">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Sisa stok:
                            <span class="font-bold underline">{{ $event->stock }} tiket lagi!</span>
                        </p>
                    </div>

                    <div class="shrink-0">
                        @if ($event->stock > 0 && $event->date > now())
                            <a
                                href="{{ route('checkout.create', $event->id) }}"
                                class="inline-block px-8 py-4 rounded-2xl bg-white text-indigo-600 font-black text-lg shadow-xl transition-transform hover:scale-105"
                            >
                                Pesan Sekarang
                            </a>
                        @else
                            <button
                                type="button"
                                disabled
                                class="inline-block px-8 py-4 rounded-2xl bg-slate-300 text-slate-500 font-black text-lg shadow-xl cursor-not-allowed"
                            >
                                {{ $event->stock <= 0 ? 'Habis' : 'Berakhir' }}
                            </button>
                        @endif
                    </div>

                </div>

                {{-- Decoration --}}
                <div class="absolute -right-16 -bottom-16 w-56 h-56 rounded-full bg-white opacity-10"></div>
                <div class="absolute -left-8 -top-8 w-28 h-28 rounded-full bg-indigo-400 opacity-20"></div>
            </div>

            {{-- Ticket Policy --}}
            <div class="space-y-4 border-t border-slate-100 pt-6">
                <h3 class="text-lg font-bold text-slate-900">Kebijakan Tiket</h3>

                <ul class="space-y-3 text-slate-500 text-sm">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.</span>
                    </li>

                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Tiket dapat discan di pintu masuk (check-in).</span>
                    </li>

                    <li class="flex items-start gap-2 text-rose-500">
                        <svg class="w-5 h-5 mt-0.5 shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Tiket yang sudah dibeli tidak dapat direfund.</span>
                    </li>
                </ul>
            </div>

            {{-- =====================================
                RATING & REVIEW
                Ikut berada di panel kanan supaya
                poster tetap diam saat review di-scroll.
            ====================================== --}}
            <section class="border-t border-slate-100 pt-6">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-black text-slate-900">Rating &amp; Review</h2>
                        <p class="text-slate-500 mt-1 text-sm">Lihat pengalaman pengunjung yang telah mengikuti event.</p>
                    </div>

                    @auth
                        <a
                            href="{{ route('reviews.create', $event) }}"
                            class="inline-block px-5 py-3 rounded-xl bg-indigo-600 text-white font-bold text-sm text-center transition-colors hover:bg-indigo-700 shrink-0"
                        >
                            Berikan Review
                        </a>
                    @endauth
                </div>

                {{-- Rating Summary --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Rating Event</p>

                        <div class="flex items-center gap-4 mt-2">
                            <span class="text-5xl font-black text-yellow-500">
                                {{ number_format($event->averageRating(), 1) }}
                            </span>

                            <div>
                                @php $rating = round($event->averageRating()); @endphp

                                <div class="flex text-yellow-400 text-xl leading-none" aria-hidden="true">
                                    @for ($i = 1; $i <= 5; $i++)
                                        {{ $i <= $rating ? '★' : '☆' }}
                                    @endfor
                                </div>

                                <p class="text-slate-500 mt-1 text-sm">
                                    {{ $event->reviews->count() }} Review
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Review List --}}
                <div class="space-y-5">

                    @forelse ($event->reviews as $review)
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 transition-shadow hover:shadow-md">

                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <h4 class="font-bold text-slate-900">{{ $review->user->name }}</h4>
                                    <p class="text-slate-400 text-xs mt-0.5">{{ $review->created_at->diffForHumans() }}</p>
                                </div>

                                <div class="shrink-0" aria-hidden="true">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="text-lg {{ $i <= $review->rating ? 'text-yellow-400' : 'text-slate-300' }}">★</span>
                                    @endfor
                                </div>
                            </div>

                            <p class="mt-4 text-slate-600 leading-7 text-sm">{{ $review->review }}</p>
                        </div>
                    @empty
                        <div class="bg-slate-100 rounded-2xl py-16 text-center">
                            <div class="text-4xl mb-3">⭐</div>
                            <h3 class="text-2xl font-black text-slate-900">Belum Ada Review</h3>
                            <p class="text-slate-500 mt-2 text-sm">
                                Jadilah pengunjung pertama yang memberikan review untuk event ini.
                            </p>

                            @auth
                                <a
                                    href="{{ route('reviews.create', $event) }}"
                                    class="inline-block mt-6 px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold text-sm transition-colors hover:bg-indigo-700"
                                >
                                    Tulis Review
                                </a>
                            @endauth
                        </div>
                    @endforelse

                </div>

            </section>

        </div>

    </div>

</main>

@endsection