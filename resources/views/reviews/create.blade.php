@extends('layouts.app')

@section('title', 'Berikan Review - ' . $event->title)

@section('content')

<main class="max-w-3xl mx-auto px-6 pt-14 pb-20">

    <div class="mb-8">
        <a href="{{ route('events.show', $event->id) }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 transition mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Event
        </a>

        <h1 class="text-3xl md:text-4xl font-black text-slate-900">Berikan Review</h1>
        <p class="text-slate-500 mt-1">Ceritakan pengalamanmu mengikuti event ini untuk membantu calon pembeli lain.</p>
    </div>

    {{-- Konteks event yang sedang direview --}}
    <div class="flex items-center gap-4 bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-8">
        <img
            src="{{ $event->poster_path ? asset('storage/' . $event->poster_path) : asset('assets/concert.png') }}"
            alt="Poster {{ $event->title }}"
            class="w-16 h-20 object-cover rounded-xl shrink-0"
        >
        <div>
            <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Event</p>
            <h2 class="font-bold text-slate-900 text-lg leading-snug">{{ $event->title }}</h2>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
        <form action="{{ route('reviews.store', $event) }}" method="POST" class="space-y-8">
            @csrf

            {{-- Rating bintang interaktif --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">Rating Anda</label>

                <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', '') }}">

                <div id="rating-stars" class="flex items-center gap-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <button
                            type="button"
                            data-star="{{ $i }}"
                            onclick="setRating({{ $i }})"
                            class="rating-star text-4xl leading-none text-slate-900 hover:text-yellow-300 transition-colors"
                        >★</button>
                    @endfor
                </div>

                <p id="rating-hint" class="text-sm text-slate-400 mt-2">Klik bintang untuk memberi nilai (1-5).</p>

                @error('rating')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <script>
                function setRating(value) {
                    document.getElementById('rating-input').value = value;
                    document.querySelectorAll('#rating-stars .rating-star').forEach(function (star) {
                        const starValue = parseInt(star.dataset.star, 10);
                        star.style.color = starValue <= value ? '#facc15' : '#0f172a';
                    });
                    document.getElementById('rating-hint').textContent = value + ' dari 5 bintang';
                }

                @if(old('rating'))
                    setRating({{ old('rating') }});
                @endif
            </script>

            {{-- Isi review --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">Ceritakan Pengalamanmu</label>

                <textarea
                    name="review"
                    rows="5"
                    maxlength="1000"
                    placeholder="Bagaimana keseruan acaranya? Apa yang paling kamu suka?"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition"
                >{{ old('review') }}</textarea>

                @error('review')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end pt-2 border-t border-slate-100">
                <button
                    type="submit"
                    class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition mt-6"
                >
                    Kirim Review
                </button>
            </div>

        </form>
    </div>

</main>

@endsection