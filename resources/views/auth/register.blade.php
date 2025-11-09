@extends('layouts.app')

@section('content')
    <section class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-10">
        <div class="max-w-5xl w-full grid md:grid-cols-2 gap-10 items-center">

            <!-- Left Side: Funny + Encouraging Text -->
            <div class="text-gray-800 space-y-6 px-6">
                <h1 class="text-4xl md:text-5xl font-extrabold text-rose-700 leading-tight">
                    Welcome to <span class="text-indigo-700">Lexicon</span> 📚
                </h1>
                <p class="text-lg text-gray-600">
                    Ready to turn pages into adventures?
                    Join <strong>Lexicon</strong> and unlock a world where books don’t just sit — they talk, laugh, and
                    sometimes cry with you.
                </p>
                <ul class="space-y-2 text-gray-700">
                    <li>✅ Borrow books faster than you can say “ISBN”</li>
                    <li>🔥 Get personalized recommendations (we know your book mood)</li>
                    <li>💬 Connect with other readers — and maybe your next book bestie</li>
                </ul>
                <p class="pt-4 text-rose-600 font-semibold">
                    Don’t just read... <span class="italic">Lexi-conquer!</span>
                </p>
            </div>

            <!-- Right Side: Registration Form -->
            <div class="bg-rose-100/80 shadow-2xl rounded-2xl p-8 backdrop-blur-sm border border-rose-200">
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Lexicon Logo" class="h-16 w-16 rounded-full shadow-lg">
                </div>

                <h2 class="text-3xl font-extrabold text-center text-rose-700 mb-6">
                    Create Your Account
                </h2>

                <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input name="name" value="{{ old('name') }}"
                            class="mt-2 w-full rounded-lg border-gray-300 focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 p-3"
                            placeholder="Jp Mbaga" required>
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input name="email" type="email" value="{{ old('email') }}"
                            class="mt-2 w-full rounded-lg border-gray-300 focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 p-3"
                            placeholder="jp@lexicon.com" required>
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input name="password" type="password"
                            class="mt-2 w-full rounded-lg border-gray-300 focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 p-3"
                            placeholder="••••••••" required>
                        @error('password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input name="password_confirmation" type="password"
                            class="mt-2 w-full rounded-lg border-gray-300 focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 p-3"
                            placeholder="••••••••" required>
                    </div>

                    <!-- Submit -->
                    <div class="pt-4">
                        <button
                            class="w-full bg-rose-600 hover:bg-rose-700 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-md">
                            Register
                        </button>
                    </div>

                    <!-- Login Link -->
                    <p class="text-center text-sm text-gray-700 mt-4">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-rose-600 hover:underline font-medium">
                            Sign in
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </section>
@endsection
