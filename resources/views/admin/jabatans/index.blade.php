@extends('layouts.admin')

@section('page_title', 'Kelola Data Jabatan')
@section('page_subtitle', 'Sisi panel admin untuk manajemen data jabatan.')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl font-semibold text-sm border border-green-100">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl font-semibold text-sm border border-red-100">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- Form Tambah --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Tambah Jabatan</h2>

            <form action="{{ route('admin.jabatans.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                        Nama Jabatan
                    </label>

                    <input
                        type="text"
                        name="name"
                        required
                        placeholder="Misal : Ketua"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 text-sm transition">

                    @error('name')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Simpan Jabatan
                </button>

            </form>
        </div>

        {{-- Tabel --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

            <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <h3 class="font-bold text-slate-800">Daftar Jabatan</h3>

                <form action="{{ route('admin.jabatans.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-72">

                    <div class="relative w-full">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari jabatan..."
                            class="w-full pl-4 pr-10 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-indigo-600">

                        @if(request('search'))
                            <a href="{{ route('admin.jabatans.index') }}"
                               class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 text-xs font-bold">
                                Clear
                            </a>
                        @endif

                    </div>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-slate-800">
                        Cari
                    </button>

                </form>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead>

                        <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold uppercase text-slate-400">

                            <th class="px-6 py-4">ID</th>

                            <th class="px-6 py-4">Nama Jabatan</th>

                            <th class="px-6 py-4">Created At</th>

                            <th class="px-6 py-4 text-center">Aksi</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-50 text-sm">

                        @forelse($jabatans as $jabatan)

                            <tr class="hover:bg-slate-50">

                                <td class="px-6 py-4">#{{ $jabatan->id }}</td>

                                <td class="px-6 py-4 font-bold">
                                    {{ $jabatan->name }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $jabatan->created_at->format('d M Y H:i') }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-3">

                                        <button
                                            onclick="openEditModal({{ $jabatan->id }}, '{{ $jabatan->name }}')"
                                            class="px-3 py-1.5 bg-amber-50 text-amber-600 rounded-lg font-bold text-xs hover:bg-amber-600 hover:text-white">

                                            Edit

                                        </button>

                                        <form
                                            action="{{ route('admin.jabatans.destroy',$jabatan->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin hapus jabatan?')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg font-bold text-xs hover:bg-red-600 hover:text-white">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center py-10 text-slate-400">
                                    Belum ada data jabatan.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

{{-- Modal Edit --}}

<div id="editModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300 flex items-center justify-center">

    <div class="bg-white rounded-2xl p-6 w-full max-w-md transform scale-95 transition-transform duration-300">

        <h3 class="text-lg font-bold mb-4">Edit Jabatan</h3>

        <form id="editForm" method="POST">

            @csrf
            @method('PUT')

            <div>

                <label class="block text-xs font-bold uppercase text-slate-400 mb-2">
                    Nama Jabatan
                </label>

                <input
                    id="edit_name"
                    type="text"
                    name="name"
                    required
                    class="w-full px-4 py-2 rounded-xl border border-slate-300">

            </div>

            <div class="flex justify-end gap-3 mt-5">

                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="px-4 py-2 bg-slate-100 rounded-xl">
                    Batal
                </button>

                <button
                    class="px-5 py-2 bg-indigo-600 text-white rounded-xl">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

<script>

function openEditModal(id,name){

    const modal=document.getElementById('editModal');

    document.getElementById('edit_name').value=name;

    document.getElementById('editForm').action="/admin/jabatans/"+id;

    modal.classList.remove('hidden');

    setTimeout(()=>{
        modal.classList.remove('opacity-0');
        modal.querySelector('div').classList.remove('scale-95');
    },10);

}

function closeEditModal(){

    const modal=document.getElementById('editModal');

    modal.classList.add('opacity-0');

    modal.querySelector('div').classList.add('scale-95');

    setTimeout(()=>{
        modal.classList.add('hidden');
    },300);

}

</script>

@endsection