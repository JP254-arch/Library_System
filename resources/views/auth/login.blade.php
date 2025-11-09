@extends('layouts.app')

@section('content')
    <section class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-10">
        <div class="max-w-5xl w-full grid md:grid-cols-2 gap-10 items-center">

            <!-- Left Side: Login Form -->
            <div class="bg-rose-100/80 shadow-2xl rounded-2xl p-8 backdrop-blur-sm border border-rose-200">
                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Lexicon Logo" class="h-16 w-16 rounded-full shadow-lg">
                </div>

                <h2 class="text-3xl font-extrabold text-center text-rose-700 mb-6">
                    Login to Lexicon
                </h2>

                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input name="email" type="email" value="{{ old('email') }}"
                            class="mt-2 w-full rounded-lg border-gray-300 focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 p-3"
                            placeholder="you@lexicon.com" required>
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

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center space-x-2 text-gray-600">
                            <input type="checkbox" name="remember"
                                class="rounded border-gray-300 text-rose-600 focus:ring-rose-200">
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="text-rose-600 hover:underline">Forgot password?</a>
                    </div>

                    <!-- Submit -->
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-rose-600 hover:bg-rose-700 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-md">
                            Login
                        </button>
                    </div>

                    <!-- Register Link -->
                    <p class="text-center text-sm text-gray-700 mt-4">
                        Don’t have an account?
                        <a href="{{ route('register') }}" class="text-rose-600 hover:underline font-medium">
                            Register
                        </a>
                    </p>
                </form>
            </div>

            <!-- Right Side: Lexicon Welcome Text -->
            <div class="text-gray-800 space-y-6 px-6">
                <h1 class="text-4xl md:text-5xl font-extrabold text-indigo-700 leading-tight">
                    Welcome Back to <span class="text-rose-600">Lexicon</span> 📚
                </h1>
                <p class="text-lg text-gray-600">
                    Missed your favorite stories? We kept your seat warm.
                    Login now and continue your reading journey — because books don’t like being left on a cliffhanger! 😉
                </p>
                <ul class="space-y-2 text-gray-700">
                    <li>📖 Continue right where you left off</li>
                    <li>💡 Get smarter with every login</li>
                    <li>💬 Meet fellow book lovers and share your reads</li>
                </ul>
                <p class="pt-4 text-indigo-700 font-semibold">
                    Let’s turn another page, together 💫
                </p>
            </div>
        </div>
    </section>
@endsection
