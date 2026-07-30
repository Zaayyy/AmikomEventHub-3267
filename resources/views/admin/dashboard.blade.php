@extends('layouts.admin')
     @section('title', 'Admin Dashboard')
     @section('page_title', 'Dashboard Ringkasan')

     @section('content')
     <!-- Stats Grid -->
     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
         <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
             <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                     </path>
                 </svg>
             </div>
             <p class="text-slate-400 text-sm font-bold uppercase mb-1">Total Pendapatan</p>
             <h3 class="text-2xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
         </div>
         <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
             <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-4">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                     </path>
                 </svg>
             </div>
             <p class="text-slate-400 text-sm font-bold uppercase mb-1">Tiket Terjual</p>
             <h3 class="text-2xl font-black">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
         </div>
         <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
             <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-4">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                 </svg>
             </div>
             <p class="text-slate-400 text-sm font-bold uppercase mb-1">Event Aktif</p>
             <h3 class="text-2xl font-black">{{ $activeEvents }} Event</h3>
         </div>
         <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
             <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-4">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                 </svg>
             </div>
             <p class="text-slate-400 text-sm font-bold uppercase mb-1">Pesanan Pending</p>
             <h3 class="text-2xl font-black">{{ $pendingOrders }} Pesanan</h3>
         </div>
     </div>

     <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
         <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
             <div class="flex items-start justify-between gap-4 mb-6">
                 <div>
                     <h3 class="font-black text-xl">Pertumbuhan Event {{ now()->year }}</h3>
                     <p class="text-sm text-slate-400 font-semibold mt-1">Grafik ringkas jumlah event per bulan.</p>
                 </div>
                 <div class="text-right">
                     <p class="text-xs text-slate-400 font-bold uppercase">User</p>
                     <p class="font-black text-slate-800">{{ number_format($totalUsers, 0, ',', '.') }}</p>
                 </div>
             </div>

             <div class="flex items-end justify-between gap-2 h-56 px-2">
                 @foreach($monthlyEvents as $item)
                     @php
                         $percent = max(($item->total / $maxMonthlyEvents) * 100, 6);
                     @endphp
                     <div class="flex-1 h-full flex flex-col items-center justify-end gap-2 group">
                         <span class="text-[10px] font-bold text-slate-500">{{ $item->total }}</span>
                         <div class="w-full max-w-[1.75rem] bg-slate-100 rounded-lg overflow-hidden flex items-end" style="height: 100%">
                             <div
                                 class="w-full bg-indigo-600 rounded-lg group-hover:bg-indigo-500 transition-colors"
                                 style="height: {{ $percent }}%"
                             ></div>
                         </div>
                         <span class="text-[10px] font-bold text-slate-400">{{ $item->month_name }}</span>
                     </div>
                 @endforeach
             </div>
         </div>

         <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
             <div class="flex items-start justify-between gap-4 mb-6">
                 <div>
                     <h3 class="font-black text-xl">Penyelenggara Aktif</h3>
                     <p class="text-sm text-slate-400 font-semibold mt-1">Jumlah event berdasarkan kepanitiaan/HIMA.</p>
                 </div>
                 <div class="text-right">
                     <p class="text-xs text-slate-400 font-bold uppercase">Partner</p>
                     <p class="font-black text-slate-800">{{ number_format($totalPartners, 0, ',', '.') }}</p>
                 </div>
             </div>

             @php
                 $organizerColors = ['#4f46e5', '#22c55e', '#f59e0b', '#ef4444', '#0ea5e9', '#a855f7'];
                 $totalOrganizerEvents = $organizerStats->sum('events_count');
                 $cumulativePercent = 0;
                 $gradientStops = [];

                 foreach ($organizerStats as $index => $partner) {
                     $sliceColor = $organizerColors[$index % count($organizerColors)];
                     $sliceStart = $cumulativePercent;
                     $slicePercent = $totalOrganizerEvents > 0
                         ? ($partner->events_count / $totalOrganizerEvents) * 100
                         : 0;
                     $cumulativePercent += $slicePercent;

                     $gradientStops[] = "{$sliceColor} {$sliceStart}% {$cumulativePercent}%";
                 }

                 $conicGradient = count($gradientStops)
                     ? implode(', ', $gradientStops)
                     : '#e2e8f0 0% 100%';
             @endphp

             @if($organizerStats->isEmpty())
                 <div class="p-8 text-center border border-dashed border-slate-200 rounded-2xl text-slate-400 font-semibold">
                     Belum ada penyelenggara.
                 </div>
             @else
                 <div class="flex flex-col sm:flex-row items-center gap-8">

                     {{-- Diagram Lingkaran --}}
                     <div
                         class="relative w-40 h-40 rounded-full shrink-0"
                         style="background: conic-gradient({{ $conicGradient }});"
                     >
                         <div class="absolute inset-4 bg-white rounded-full flex flex-col items-center justify-center">
                             <span class="text-2xl font-black text-slate-800">{{ $totalOrganizerEvents }}</span>
                             <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Total Event</span>
                         </div>
                     </div>

                     {{-- Legenda --}}
                     <div class="w-full space-y-3">
                         @foreach($organizerStats as $index => $partner)
                             <div class="flex items-center justify-between text-sm gap-3">
                                 <div class="flex items-center gap-2 min-w-0">
                                     <span
                                         class="w-3 h-3 rounded-full shrink-0"
                                         style="background: {{ $organizerColors[$index % count($organizerColors)] }}"
                                     ></span>
                                     <span class="font-bold text-slate-700 truncate">{{ $partner->name }}</span>
                                 </div>
                                 <span class="text-slate-400 font-semibold shrink-0">{{ $partner->events_count }} event</span>
                             </div>
                         @endforeach
                     </div>

                 </div>
             @endif
         </div>
     </div>

     <!-- Latest Sales Table -->
     <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
         <div class="p-8 border-b flex justify-between items-center">
             <h3 class="font-black text-xl">Transaksi Terakhir</h3>
             <a href="{{ route('admin.transactions.index') }}" class="text-indigo-600 font-bold hover:underline">Lihat Semua</a>
         </div>
         <div class="overflow-x-auto">
             <table class="w-full text-left border-collapse">
                 <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                     <tr>
                         <th class="px-8 py-4 w-1/4">Tgl Transaksi</th>
                         <th class="px-8 py-4 w-1/4">Pembeli</th>
                         <th class="px-8 py-4 w-1/4">Event</th>
                         <th class="px-8 py-4 w-[10%]">Status</th>
                         <th class="px-8 py-4 text-right">Total</th>
                     </tr>
                 </thead>
                 <tbody class="divide-y border-t">
                     @forelse($recentTransactions as $trx)
                     <tr class="hover:bg-slate-50 transition">
                         <td class="px-8 py-6 text-sm text-slate-600 max-w-xs break-all">{{ $trx->created_at->format('d M y - H:i') }}<br><span class="text-xs text-slate-400">{{ $trx->order_id }}</span></td>
                         <td class="px-8 py-6">
                             <p class="font-bold uppercase tracking-wide text-sm truncate max-w-[150px]">{{ $trx->customer_name }}</p>
                             <p class="text-xs text-slate-400 truncate max-w-[150px]">{{ $trx->customer_email }}</p>
                         </td>
                         <td class="px-8 py-6 font-medium text-slate-600 max-w-xs truncate">{{ $trx->event->title ?? '-' }}</td>
                         <td class="px-8 py-6 whitespace-nowrap">
                             @if($trx->status === 'settlement' || $trx->status === 'success')
                                 <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">Success</span>
                             @elseif($trx->status === 'pending')
                                 <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase">Pending</span>
                             @else
                                 <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase">{{ $trx->status }}</span>
                             @endif
                         </td>
                         <td class="px-8 py-6 font-black text-indigo-600 whitespace-nowrap text-right">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                     </tr>
                     @empty
                     <tr>
                         <td colspan="5" class="px-8 py-10 text-center text-slate-500">Belum ada transaksi</td>
                     </tr>
                     @endforelse
                 </tbody>
             </table>
         </div>
     </div>
     @endsection