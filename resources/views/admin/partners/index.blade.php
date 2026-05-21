@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kelola Partner & Sponsor</h1>
        <p class="text-slate-500 text-sm mt-1">Sisi panel admin untuk manajemen data partner kerja sama AmikomEventHub.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl font-semibold text-sm border border-green-100">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Tambah Partner</h2>
            <form action="{{ route('admin.partners.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Nama Perusahaan/Brand</label>
                    <input type="text" name="name" required placeholder="Misal: PT. Tech Indo"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 text-sm transition">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">URL Logo Gambar</label>
                    <input type="url" name="logo_url" required placeholder="https://example.com/logo.png"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 text-sm transition">
                </div>
                <button type="submit" class="w-full py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Simpan Partner
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <h3 class="font-bold text-slate-800">Daftar Partner</h3>
                <form action="{{ route('admin.partners.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-72">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari partner..." 
                               class="w-full pl-4 pr-10 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-indigo-600 transition">
                        @if(request('search'))
                            <a href="{{ route('admin.partners.index') }}" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 text-xs font-bold">Clear</a>
                        @endif
                    </div>
                    <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-slate-800 transition">
                        Cari
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold uppercase text-slate-400 tracking-wider">
                            <th class="px-6 py-4">Logo</th>
                            <th class="px-6 py-4">Nama Perusahaan</th>
                            <th class="px-6 py-4">Terdaftar Pada</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm text-slate-600">
                        @forelse($partners as $partner)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="w-16 h-10 bg-slate-50 rounded-lg p-1 flex items-center justify-center border border-slate-100">
                                        <img src="{{ $partner->logo_url }}" alt="Logo" class="max-w-full max-h-full object-contain">
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $partner->name }}</td>
                                <td class="px-6 py-4 text-xs text-slate-400">{{ $partner->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-3">
                                        <button onclick="openEditModal({{ $partner->id }}, '{{ $partner->name }}', '{{ $partner->logo_url }}')" 
                                                class="px-3 py-1.5 bg-amber-50 text-amber-600 font-bold text-xs rounded-lg hover:bg-amber-600 hover:text-white transition">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 font-bold text-xs rounded-lg hover:bg-red-600 hover:text-white transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium">Belum ada mitra/partner kerja sama terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md m-4 transform scale-95 transition-transform duration-300">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Edit Data Partner</h3>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Nama Partner Baru</label>
                <input type="text" id="edit_name" name="name" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 text-sm transition">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">URL Logo Baru</label>
                <input type="url" id="edit_logo_url" name="logo_url" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 text-sm transition">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs hover:bg-slate-200 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-xl font-bold text-xs hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name, logoUrl) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        const inputName = document.getElementById('edit_name');
        const inputLogoUrl = document.getElementById('edit_logo_url');
        
        form.action = `/admin/partners/${id}`;
        inputName.value = name;
        inputLogoUrl.value = logoUrl; // PERBAIKAN: Isi otomatis value input URL modal edit

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('div').classList.remove('scale-95');
        }, 10);
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.classList.add('opacity-0');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection