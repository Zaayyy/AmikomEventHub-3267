@extends('layouts.admin')

@section('page_title', 'Kelola Partner & Sponsor')
@section('page_subtitle', 'Sisi panel admin untuk manajemen data partner kerja sama AmikomEventHub.')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-10">

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-100 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- Ringkasan error, muncul kalau ada validasi yang gagal di form manapun di halaman ini --}}
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-100 font-semibold">
            <p class="mb-2">Data gagal disimpan, mohon periksa kembali isian berikut:</p>
            <ul class="list-disc list-inside text-sm font-normal space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- ================= FORM TAMBAH PARTNER ================= --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">

            <h2 class="text-lg font-bold text-slate-800 mb-6">
                Tambah Partner
            </h2>

            <form action="{{ route('admin.partners.store') }}" method="POST" class="space-y-5">

                @csrf

                <div>
                    <label class="block text-xs uppercase font-bold tracking-wider text-slate-400 mb-2">
                        Nama Perusahaan / Organisasi
                    </label>

                    <input
                        type="text"
                        name="name"
                        required
                        value="{{ old('name') }}"
                        placeholder="Contoh : HIMA SI AMIKOM"
                        class="w-full px-4 py-3 rounded-xl border @error('name') border-red-400 @else border-slate-200 @enderror focus:border-indigo-600 focus:outline-none">

                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs uppercase font-bold tracking-wider text-slate-400 mb-2">
                        Logo URL
                    </label>

                    <input
                        type="url"
                        name="logo_url"
                        required
                        value="{{ old('logo_url') }}"
                        placeholder="https://..."
                        class="w-full px-4 py-3 rounded-xl border @error('logo_url') border-red-400 @else border-slate-200 @enderror focus:border-indigo-600 focus:outline-none">

                    @error('logo_url')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs uppercase font-bold tracking-wider text-slate-400 mb-2">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        rows="3"
                        placeholder="Deskripsi partner..."
                        class="w-full px-4 py-3 rounded-xl border @error('description') border-red-400 @else border-slate-200 @enderror focus:border-indigo-600 focus:outline-none">{{ old('description') }}</textarea>

                    @error('description')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr>

                <div class="bg-indigo-50 rounded-xl p-4">

                    <h4 class="font-bold text-indigo-700 mb-4">
                        Akun Login Partner
                    </h4>

                    <div class="space-y-4">

                        <div>

                            <label class="block text-xs uppercase font-bold tracking-wider text-slate-500 mb-2">
                                Email Login
                            </label>

                            <input
                                type="email"
                                name="email"
                                required
                                value="{{ old('email') }}"
                                placeholder="partner@email.com"
                                class="w-full px-4 py-3 rounded-xl border @error('email') border-red-400 @else border-slate-200 @enderror focus:border-indigo-600 focus:outline-none">

                            @error('email')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                        </div>

                        <div>

                            <label class="block text-xs uppercase font-bold tracking-wider text-slate-500 mb-2">
                                Password Awal
                            </label>

                            <input
                                type="password"
                                name="password"
                                required
                                placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-3 rounded-xl border @error('password') border-red-400 @else border-slate-200 @enderror focus:border-indigo-600 focus:outline-none">

                            @error('password')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @else
                                <p class="text-xs text-slate-400 mt-2">
                                    Password ini akan digunakan partner saat login dashboard.
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold transition">

                    Simpan Partner

                </button>

            </form>

        </div>

        {{-- =================== TABEL =================== --}}

        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

            <div class="p-6 border-b border-slate-100 flex items-center justify-between">

                <div>

                    <h3 class="font-bold text-slate-800">
                        Daftar Partner
                    </h3>

                    <p class="text-xs text-slate-400 mt-1">
                        Partner yang telah terdaftar pada sistem.
                    </p>

                </div>

                <form action="{{ route('admin.partners.index') }}" method="GET">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari partner..."
                        class="px-4 py-2 rounded-xl border border-slate-200 focus:border-indigo-600 focus:outline-none">

                </form>

            </div>

            <div class="overflow-x-auto">
                <table class="w-full">

    <thead class="bg-slate-50 border-b border-slate-100">

        <tr class="text-xs uppercase tracking-wider text-slate-400">

            <th class="px-6 py-4 text-left">
                Logo
            </th>

            <th class="px-6 py-4 text-left">
                Partner
            </th>

            <th class="px-6 py-4 text-left">
                Akun Login
            </th>

            <th class="px-6 py-4 text-left">
                Event
            </th>

            <th class="px-6 py-4 text-center">
                Aksi
            </th>

        </tr>

    </thead>

    <tbody class="divide-y divide-slate-100">

        @forelse($partners as $partner)

        <tr class="hover:bg-slate-50 transition">

            {{-- Logo --}}
            <td class="px-6 py-5">

                <img
                    src="{{ $partner->logo_url }}"
                    class="w-16 h-16 rounded-xl object-cover border">

            </td>

            {{-- Nama --}}
            <td class="px-6 py-5">

                <div class="font-bold text-slate-800">

                    {{ $partner->name }}

                </div>

                <div class="text-sm text-slate-500 mt-1">

                    {{ $partner->description ?: '-' }}

                </div>

            </td>

            {{-- Akun Login --}}
            <td class="px-6 py-5">

                @if($partner->user)

                    <div class="space-y-1">

                        <div class="font-semibold text-slate-700">

                            {{ $partner->user->email }}

                        </div>

                        <span class="inline-flex items-center px-2 py-1 rounded-lg bg-green-100 text-green-700 text-xs font-bold">

                            Aktif

                        </span>

                    </div>

                @else

                    <span class="inline-flex items-center px-2 py-1 rounded-lg bg-red-100 text-red-600 text-xs font-bold">

                        Belum Ada Akun

                    </span>

                @endif

            </td>

            {{-- Jumlah Event --}}
            <td class="px-6 py-5">

                <span class="font-bold text-indigo-600">

                    {{ $partner->events->count() }}

                </span>

                Event

            </td>

            {{-- Tombol --}}
            <td class="px-6 py-5">

                <div class="flex justify-center gap-2">

                    <button
                        onclick="openEditModal(
                            {{ $partner->id }},
                            @js($partner->name),
                            @js($partner->logo_url),
                            @js($partner->description),
                            @js(optional($partner->user)->email)
                        )"
                        class="px-4 py-2 rounded-lg bg-amber-500 text-white hover:bg-amber-600 font-bold">

                        Edit

                    </button>

                    <form
                        action="{{ route('admin.partners.destroy',$partner) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin hapus partner ini?')">

                        @csrf
                        @method('DELETE')

                        <button
                            class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 font-bold">

                            Hapus

                        </button>

                    </form>

                </div>

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="5" class="text-center py-12 text-slate-400">

                Belum ada partner.

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</div>

</div>

</div>
{{-- ================= MODAL EDIT ================= --}}

<div id="editModal"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">

    <div class="bg-white rounded-3xl w-full max-w-lg p-8 shadow-2xl">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-2xl font-black text-slate-800">
                Edit Partner
            </h2>

            <button
                onclick="closeEditModal()"
                class="text-slate-500 hover:text-red-500 text-2xl">

                &times;

            </button>

        </div>

        <form
            id="editForm"
            method="POST">

            @csrf
            @method('PUT')

            <div class="space-y-5">

                <div>

                    <label class="block font-semibold mb-2">
                        Nama Partner
                    </label>

                    <input
                        id="edit_name"
                        name="name"
                        type="text"
                        required
                        class="w-full rounded-xl border px-4 py-3">

                </div>

                <div>

                    <label class="block font-semibold mb-2">
                        Logo URL
                    </label>

                    <input
                        id="edit_logo_url"
                        name="logo_url"
                        type="text"
                        required
                        class="w-full rounded-xl border px-4 py-3">

                </div>

                <div>

                    <label class="block font-semibold mb-2">
                        Deskripsi
                    </label>

                    <textarea
                        id="edit_description"
                        name="description"
                        rows="3"
                        class="w-full rounded-xl border px-4 py-3"></textarea>

                </div>

                <hr>

                <h4 class="font-bold text-indigo-600">
                    Akun Login Partner
                </h4>

                <div>

                    <label class="block font-semibold mb-2">
                        Email
                    </label>

                    <input
                        id="edit_email"
                        name="email"
                        type="email"
                        class="w-full rounded-xl border px-4 py-3">

                </div>

                <div>

                    <label class="block font-semibold mb-2">
                        Password Baru
                    </label>

                    <input
                        name="password"
                        type="password"
                        placeholder="Kosongkan jika tidak ingin mengganti password"
                        class="w-full rounded-xl border px-4 py-3">

                </div>

            </div>

            <div class="flex justify-end gap-3 mt-8">

                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="px-5 py-3 rounded-xl bg-slate-200 hover:bg-slate-300 font-bold">

                    Batal

                </button>

                <button
                    type="submit"
                    class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function openEditModal(id,name,logo,description,email){

    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');

    document.getElementById('editForm').action='/admin/partners/'+id;

    document.getElementById('edit_name').value=name;
    document.getElementById('edit_logo_url').value=logo;
    document.getElementById('edit_description').value=description ?? '';
    document.getElementById('edit_email').value=email ?? '';

}

function closeEditModal(){

    document.getElementById('editModal').classList.remove('flex');
    document.getElementById('editModal').classList.add('hidden');

}

@if($errors->any())
    // Kalau ada error validasi dan itu berasal dari form Edit (bukan form Tambah),
    // otomatis buka lagi modal edit-nya supaya tidak hilang begitu saja.
    // (Opsional — hapus blok ini kalau kamu tidak butuh perilaku ini)
@endif

</script>

@endsection