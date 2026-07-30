@extends('layouts.partner')

@section('page_title', 'Dashboard Partner')
@section('page_subtitle', 'Ringkasan event dan performa ' . $partner->name)

@section('content')

<div class="space-y-8">

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-indigo-600 rounded-2xl shadow-sm p-6 text-white">
            <p class="text-xs uppercase font-bold tracking-wider text-indigo-200 mb-3">
                Total Pendapatan
            </p>
            <p class="text-3xl font-black">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </p>
            <p class="text-indigo-200 text-sm mt-2">
                {{ $totalTicketsSold }} tiket terjual
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <p class="text-xs uppercase font-bold tracking-wider text-slate-400 mb-3">
                Total Event
            </p>
            <p class="text-4xl font-black text-indigo-600">
                {{ $totalEvent }}
            </p>
        </div>

        <a href="{{ route('partner.reviews.index') }}" class="block bg-white rounded-2xl border border-slate-100 shadow-sm p-6 hover:border-indigo-200 hover:shadow-md transition">
            <p class="text-xs uppercase font-bold tracking-wider text-slate-400 mb-3">
                Total Review
            </p>
            <p class="text-4xl font-black text-indigo-600">
                {{ $totalReview }}
            </p>
        </a>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <p class="text-xs uppercase font-bold tracking-wider text-slate-400 mb-3">
                Rating Rata-rata
            </p>
            <div class="flex items-center gap-2">
                <p class="text-4xl font-black text-yellow-500">
                    {{ $averageRating }}
                </p>
                <span class="text-yellow-400 text-xl">★</span>
            </div>
        </div>

    </div>

    {{-- ================= DAFTAR EVENT ================= --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        <div class="p-6 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">
                Event Saya
            </h3>
            <p class="text-xs text-slate-400 mt-1">
                Daftar event yang telah dibuat untuk {{ $partner->name }}.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">

                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr class="text-xs uppercase tracking-wider text-slate-400">
                        <th class="px-6 py-4 text-left">Event</th>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Harga</th>
                        <th class="px-6 py-4 text-left">Stok</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($events as $event)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-5 font-bold text-slate-800">
                                {{ $event->title }}
                            </td>
                            <td class="px-6 py-5 text-slate-500">
                                {{ $event->date->translatedFormat('d M Y - H:i') }}
                            </td>
                            <td class="px-6 py-5 text-slate-500">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-5 text-slate-500">
                                {{ $event->stock }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 text-slate-400">
                                Belum ada event yang dibuat.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection