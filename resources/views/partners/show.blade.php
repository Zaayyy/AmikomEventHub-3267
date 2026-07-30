@extends('layouts.app')

@section('title', $partner->name)

@section('content')

<div class="max-w-7xl mx-auto px-6 py-12">

    {{-- ================= HEADER ================= --}}
    <div class="bg-gradient-to-r from-indigo-600 to-violet-600 rounded-[32px] p-10 text-white shadow-xl">

        <div class="flex flex-col md:flex-row items-center gap-8">

            <img
                src="{{ $partner->logo_url }}"
                class="w-36 h-36 rounded-3xl object-cover border-4 border-white shadow-lg">

            <div class="flex-1">

                <h1 class="text-5xl font-black">

                    {{ $partner->name }}

                </h1>

                <p class="text-indigo-100 mt-4 text-lg leading-relaxed">

                    {{ $partner->description }}

                </p>

            </div>

        </div>

    </div>



    {{-- ================= STATISTIK ================= --}}
    <div class="grid md:grid-cols-3 gap-6 mt-10">

        <div class="bg-white rounded-3xl shadow border p-8 text-center">

            <div class="text-yellow-500 text-5xl mb-4">

                ⭐

            </div>

            <div class="text-4xl font-black">

                {{ number_format($partner->averageRating(),1) }}

            </div>

            <p class="text-slate-500 mt-2">

                Rating Partner

            </p>

        </div>

        <div class="bg-white rounded-3xl shadow border p-8 text-center">

            <div class="text-indigo-600 text-5xl mb-4">

                📝

            </div>

            <div class="text-4xl font-black">

                {{ $reviews->count() }}

            </div>

            <p class="text-slate-500 mt-2">

                Total Review

            </p>

        </div>

        <div class="bg-white rounded-3xl shadow border p-8 text-center">

            <div class="text-green-600 text-5xl mb-4">

                🎫

            </div>

            <div class="text-4xl font-black">

                {{ $partner->events->count() }}

            </div>

            <p class="text-slate-500 mt-2">

                Total Event

            </p>

        </div>

    </div>



    {{-- ================= EVENT ================= --}}
    <div class="mt-16">

        <h2 class="text-3xl font-black mb-8">

            Event Yang Diselenggarakan

        </h2>

        <div class="grid md:grid-cols-3 gap-8">

            @forelse($partner->events as $event)

            <div class="bg-white rounded-3xl overflow-hidden shadow border hover:shadow-xl transition">

                @if($event->poster_path)

                    <img
                        src="{{ asset('storage/'.$event->poster_path) }}"
                        class="w-full h-56 object-cover">

                @endif

                <div class="p-6">

                    <span class="inline-block px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold mb-3">

                        {{ $event->category->name }}

                    </span>

                    <h3 class="text-xl font-black">

                        {{ $event->title }}

                    </h3>

                    <p class="text-slate-500 mt-3">

                        📅 {{ $event->date->format('d M Y') }}

                    </p>

                    <p class="text-slate-500">

                        📍 {{ $event->location }}

                    </p>

                    <p class="mt-5 text-2xl font-black text-indigo-600">

                        Rp {{ number_format($event->price,0,',','.') }}

                    </p>

                    <a
                        href="{{ route('events.show',$event) }}"
                        class="block text-center mt-6 bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-bold transition">

                        Lihat Detail

                    </a>

                </div>

            </div>

            @empty

            <div class="col-span-3">

                <div class="bg-slate-100 rounded-3xl py-16 text-center">

                    <div class="text-6xl mb-4">

                        📅

                    </div>

                    <h3 class="text-2xl font-bold">

                        Belum Ada Event

                    </h3>

                </div>

            </div>

            @endforelse

        </div>

    </div>



    {{-- ================= REVIEW ================= --}}
    <div class="mt-20">

        <h2 class="text-3xl font-black mb-8">

            Review Pengunjung

        </h2>

        @forelse($reviews as $review)

        <div class="bg-white rounded-3xl shadow border p-8 mb-6">

            <div class="flex justify-between">

                <div>

                    <h3 class="font-bold text-lg">

                        {{ $review->user->name }}

                    </h3>

                    <p class="text-slate-500 text-sm">

                        Event :

                        {{ $review->event->title }}

                    </p>

                </div>

                <div>

                    @for($i=1;$i<=5;$i++)

                        @if($i <= $review->rating)

                            <span class="text-yellow-400 text-xl">★</span>

                        @else

                            <span class="text-gray-300 text-xl">★</span>

                        @endif

                    @endfor

                </div>

            </div>

            <p class="mt-5 text-slate-600 leading-relaxed">

                {{ $review->review }}

            </p>

            <div class="mt-4 text-sm text-slate-400">

                {{ $review->created_at->format('d M Y') }}

            </div>

        </div>

        @empty

        <div class="bg-slate-100 rounded-3xl py-16 text-center">

            <div class="text-6xl mb-4">

                ⭐

            </div>

            <h3 class="text-2xl font-bold">

                Belum Ada Review

            </h3>

            <p class="text-slate-500 mt-3">

                Review dari pengunjung akan muncul di sini.

            </p>

        </div>

        @endforelse

    </div>

</div>

@endsection