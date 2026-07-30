@extends('layouts.app')

@section('title','Login Partner')

@section('content')

<div class="min-h-[80vh] flex items-center justify-center px-6 py-16">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-slate-200 p-10">

        <div class="text-center mb-10">

            <div class="w-20 h-20 rounded-3xl bg-indigo-600 mx-auto flex items-center justify-center text-white text-3xl font-black">
                P
            </div>

            <h1 class="text-3xl font-black mt-6">
                Login Partner
            </h1>

            <p class="text-slate-500 mt-2">
                Masuk untuk mengelola event Anda
            </p>

        </div>

        @if(session('error'))
            <div class="mb-5 rounded-xl bg-red-100 text-red-700 p-4 font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('partner.authenticate') }}" method="POST">

            @csrf

            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border rounded-xl p-4 focus:ring-2 focus:ring-indigo-500"
                    required
                >

                @error('email')
                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div class="mb-8">

                <label class="block font-semibold mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full border rounded-xl p-4 focus:ring-2 focus:ring-indigo-500"
                    required
                >

            </div>

            <button
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-xl font-bold transition"
            >
                Login
            </button>

        </form>

    </div>

</div>

@endsection