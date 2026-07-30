@extends('layouts.app')

@section('title', 'Daftar Jadi Partner')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-16">

    {{-- Header --}}
    <div class="text-center mb-10">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-wider mb-4">
            Kemitraan
        </span>
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3">
            Daftarkan Organisasi Menjadi Partner
        </h1>
        <p class="text-slate-500 max-w-xl mx-auto leading-relaxed">
            Lengkapi formulir di bawah ini. Tim kami akan meninjau pengajuan Anda
            dan menghubungi melalui email yang didaftarkan.
        </p>
    </div>

    {{-- Validation summary --}}
    @if ($errors->any())
        <div class="mb-8 bg-red-50 border border-red-200 text-red-700 rounded-2xl p-5">
            <p class="font-bold text-sm mb-2">Terdapat kesalahan pada form:</p>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('partner-registration.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white border border-slate-100 rounded-[2rem] shadow-sm p-8 md:p-12 space-y-12">
        @csrf

        {{-- Section: Informasi Organisasi --}}
        <div>
            <h2 class="text-lg font-extrabold text-slate-900 mb-1">Informasi Organisasi</h2>
            <p class="text-sm text-slate-400 mb-6">Data dasar mengenai organisasi Anda.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Nama Organisasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="organization_name"
                           value="{{ old('organization_name') }}"
                           required
                           placeholder="cth. Himpunan Mahasiswa Informatika"
                           class="w-full px-4 py-3 rounded-xl border @error('organization_name') border-red-400 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('organization_name')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Jenis Organisasi <span class="text-red-500">*</span>
                    </label>
                    <select name="organization_type"
                            required
                            class="w-full px-4 py-3 rounded-xl border @error('organization_type') border-red-400 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white">
                        <option value="" disabled {{ old('organization_type') ? '' : 'selected' }}>Pilih jenis organisasi</option>
                        @foreach (['Perusahaan', 'Komunitas', 'UKM', 'Media Partner', 'Sponsor'] as $type)
                            <option value="{{ $type }}" {{ old('organization_type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @error('organization_type')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Deskripsi Organisasi <span class="text-red-500">*</span>
                </label>
                <textarea name="description"
                          rows="4"
                          required
                          placeholder="Ceritakan singkat mengenai organisasi, kegiatan, dan tujuan kemitraan Anda."
                          class="w-full px-4 py-3 rounded-xl border @error('description') border-red-400 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <hr class="border-slate-100">

        {{-- Section: Kontak & Alamat --}}
        <div>
            <h2 class="text-lg font-extrabold text-slate-900 mb-1">Kontak &amp; Alamat</h2>
            <p class="text-sm text-slate-400 mb-6">Digunakan tim kami untuk menghubungi Anda.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           placeholder="organisasi@email.com"
                           class="w-full px-4 py-3 rounded-xl border @error('email') border-red-400 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        No. HP / WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="phone"
                           value="{{ old('phone') }}"
                           required
                           placeholder="08xxxxxxxxxx"
                           class="w-full px-4 py-3 rounded-xl border @error('phone') border-red-400 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Alamat <span class="text-red-500">*</span>
                </label>
                <textarea name="address"
                          rows="3"
                          required
                          placeholder="Alamat lengkap sekretariat / kantor organisasi"
                          class="w-full px-4 py-3 rounded-xl border @error('address') border-red-400 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none">{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <hr class="border-slate-100">

        {{-- Section: Dokumen --}}
        <div>
            <h2 class="text-lg font-extrabold text-slate-900 mb-1">Dokumen Pendukung</h2>
            <p class="text-sm text-slate-400 mb-6">Logo akan tampil di halaman partner kami, dan proposal membantu proses review.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Logo Organisasi <span class="text-red-500">*</span>
                    </label>
                    <label class="flex flex-col items-center justify-center gap-2 px-4 py-8 rounded-xl border-2 border-dashed @error('logo') border-red-400 bg-red-50 @else border-slate-200 hover:border-indigo-400 hover:bg-indigo-50/50 @enderror transition cursor-pointer text-center">
                        <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-xs font-bold text-slate-600">Klik untuk unggah logo</span>
                        <span class="text-[11px] text-slate-400">JPG atau PNG, maks. 2MB</span>
                        <input type="file" name="logo" accept=".jpg,.jpeg,.png" required class="hidden">
                    </label>
                    @error('logo')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Proposal Kerja Sama (PDF) <span class="text-red-500">*</span>
                    </label>
                    <label class="flex flex-col items-center justify-center gap-2 px-4 py-8 rounded-xl border-2 border-dashed @error('proposal') border-red-400 bg-red-50 @else border-slate-200 hover:border-indigo-400 hover:bg-indigo-50/50 @enderror transition cursor-pointer text-center">
                        <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-xs font-bold text-slate-600">Klik untuk unggah proposal</span>
                        <span class="text-[11px] text-slate-400">PDF, maks. 5MB</span>
                        <input type="file" name="proposal" accept=".pdf" required class="hidden">
                    </label>
                    @error('proposal')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="pt-4 flex flex-col md:flex-row items-center justify-between gap-4 border-t border-slate-100">
            <p class="text-xs text-slate-400 max-w-sm">
                Dengan mengirim formulir ini, Anda menyetujui data akan digunakan
                untuk keperluan verifikasi kemitraan oleh AmikomEventHub.
            </p>
            <button type="submit"
                    class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:scale-105 transition-transform whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                Kirim Pengajuan
            </button>
        </div>
    </form>
</section>

<script>
    // Tampilkan nama file yang dipilih pada area unggah
    document.querySelectorAll('input[type="file"]').forEach(function (input) {
        input.addEventListener('change', function () {
            const label = input.closest('label');
            const nameEl = label.querySelector('span.text-xs');
            if (input.files && input.files.length > 0 && nameEl) {
                nameEl.textContent = input.files[0].name;
            }
        });
    });
</script>
@endsection