@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[60vh]">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-sm">
        <h2 class="text-2xl font-bold text-center mb-6 text-indigo-600">Login to Lexicon</h2>

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input name="email" type="email" value="{{ old('email') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input name="password" type="password"
                    class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
                Login
            </button>

            <p class="text-center text-sm text-gray-500 mt-4">
                Don't have an account? <a href="{{ route('register') }}"
                    class="text-indigo-600 hover:underline">Register</a>
            </p>
        </form>
    </div>
</div>
@endsection
