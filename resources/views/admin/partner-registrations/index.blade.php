@extends('layouts.admin')

@section('page_title', 'Pengajuan Partner')
@section('page_subtitle', 'Tinjau dan kelola pengajuan kemitraan organisasi')

@section('content')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    <table class="w-full text-sm">
        <thead>
            <tr class="bg-slate-50 text-left text-slate-500 text-xs font-bold uppercase tracking-wide">
                <th class="px-6 py-4">No</th>
                <th class="px-6 py-4">Organisasi</th>
                <th class="px-6 py-4">Jenis</th>
                <th class="px-6 py-4">Email</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-100">
        @forelse($registrations as $registration)
            <tr class="hover:bg-slate-50/60 transition">
                <td class="px-6 py-4 text-slate-500">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 font-bold text-slate-800">{{ $registration->organization_name }}</td>
                <td class="px-6 py-4 text-slate-600">{{ $registration->organization_type }}</td>
                <td class="px-6 py-4 text-slate-600">{{ $registration->email }}</td>
                <td class="px-6 py-4">
                    @if($registration->status == 'pending')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-bold">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Pending
                        </span>
                    @elseif($registration->status == 'approved')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Approved
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-bold">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Rejected
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.partner-registrations.show', $registration->id) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold text-xs hover:bg-indigo-700 transition shadow-sm">
                        Detail
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-16 text-center text-slate-400 font-medium">
                    Belum ada pengajuan partner.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

@endsection