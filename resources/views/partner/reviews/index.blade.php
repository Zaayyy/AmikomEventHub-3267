@extends('layouts.partner')
@section('title', 'Review & Rating - Partner')
@section('page_title', 'Review & Rating')
@section('page_subtitle', 'Lihat dan balas review dari pengunjung event Anda.')

@section('content')

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-100 font-semibold">
        {{ session('success') }}
    </div>
@endif

<div class="space-y-6">

    @forelse($reviews as $review)
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-7">

            <div class="flex justify-between items-start gap-4">
                <div>
                    <span class="inline-block px-3 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-bold mb-2">
                        {{ $review->event->title ?? 'Event dihapus' }}
                    </span>
                    <h4 class="font-bold text-lg text-slate-900">{{ $review->user->name ?? 'Pengguna' }}</h4>
                    <p class="text-slate-400 text-sm">{{ $review->created_at->diffForHumans() }}</p>
                </div>

                <div class="shrink-0" aria-hidden="true">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="text-xl {{ $i <= $review->rating ? 'text-yellow-400' : 'text-slate-300' }}">★</span>
                    @endfor
                </div>
            </div>

            <p class="mt-4 text-slate-600 leading-8">{{ $review->review }}</p>

            {{-- Balasan yang sudah ada --}}
            @if($review->reply)
                <div class="mt-5 ml-4 md:ml-8 p-5 bg-indigo-50 rounded-2xl border border-indigo-100">
                    <p class="text-xs font-bold uppercase tracking-wide text-indigo-500 mb-1">
                        Balasan Anda &middot; {{ $review->replied_at?->diffForHumans() }}
                    </p>
                    <p class="text-slate-700 leading-7">{{ $review->reply }}</p>
                </div>
            @endif

            {{-- Form balas / perbarui balasan --}}
            <form action="{{ route('partner.reviews.reply', $review) }}" method="POST" class="mt-4">
                @csrf
                <label class="block text-xs font-bold uppercase tracking-wide text-slate-400 mb-2">
                    {{ $review->reply ? 'Perbarui Balasan' : 'Balas Review Ini' }}
                </label>
                <textarea
                    name="reply"
                    rows="3"
                    placeholder="Tulis balasan Anda untuk pengunjung ini..."
                    class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-sm"
                >{{ old('reply', $review->reply) }}</textarea>
                @error('reply')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <div class="flex justify-end mt-2">
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition">
                        {{ $review->reply ? 'Perbarui Balasan' : 'Kirim Balasan' }}
                    </button>
                </div>
            </form>

        </div>
    @empty
        <div class="bg-white rounded-3xl border border-dashed border-slate-200 py-16 text-center">
            <div class="text-5xl mb-4">⭐</div>
            <h3 class="text-2xl font-black text-slate-800">Belum Ada Review</h3>
            <p class="text-slate-500 mt-2">Review dari pengunjung event Anda akan muncul di sini.</p>
        </div>
    @endforelse

</div>

<div class="mt-8">
    {{ $reviews->links() }}
</div>

@endsection