@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-900 shadow-lg rounded-2xl p-10 text-center">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="h-16 w-16 rounded-full shadow-md">
    </div>

    <!-- Title -->
    <h1 class="text-3xl sm:text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">
        Welcome to {{ config('app.name', 'Lexicon') }}
    </h1>

    <!-- Subtitle -->
    <p class="text-gray-600 dark:text-gray-300 text-base mb-8">
        A modern library management system designed to make book tracking and borrowing simple, elegant, and efficient.
    </p>

    <!-- Featured Books Section -->
    <section id="featured-books" class="py-10 container mx-auto px-4">
        <h2 class="text-2xl font-bold text-center mb-10 text-indigo-600 dark:text-indigo-400">
            Featured Books
        </h2>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse ($books as $book)
                @php
                    // Try to decode the JSON cover data
                    $coverData = $book->cover ? json_decode($book->cover, true) : null;

                    // Determine final cover URL
                    if (is_array($coverData)) {
                        // If cover stored as file upload
                        if (($coverData['type'] ?? null) === 'upload' && isset($coverData['path'])) {
                            $coverUrl = asset('storage/' . ltrim($coverData['path'], '/'));
                        }
                        // If cover stored as external URL
                        elseif (($coverData['type'] ?? null) === 'url' && isset($coverData['path'])) {
                            $coverUrl = $coverData['path'];
                        }
                        // Invalid structure
                        else {
                            $coverUrl = null;
                        }
                    } else {
                        $coverUrl = null;
                    }
                @endphp

                <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl overflow-hidden hover:shadow-lg transition">
                    <img
                        src="{{ $coverUrl ?? asset('images/default-cover.jpg') }}"
                        alt="{{ $book->title }}"
                        class="w-full h-48 object-cover {{ $coverUrl ? '' : 'opacity-70' }}">

                    <div class="p-5">
                        <h4 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-100">
                            {{ $book->title }}
                        </h4>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            by {{ $book->author->name ?? 'Unknown Author' }}
                        </p>
                        <a href="{{ route('books.show', $book->id) }}"
                           class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">
                            View Details →
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center col-span-3">
                    No featured books available at the moment.
                </p>
            @endforelse
        </div>
    </section>

    <!-- Buttons -->
    <div class="flex flex-wrap justify-center gap-4 mt-10">
        @guest
            <a href="{{ route('login') }}"
                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition">
                Login
            </a>
            <a href="{{ route('register') }}"
                class="px-6 py-3 border border-indigo-500 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-gray-800 rounded-xl font-semibold transition">
                Register
            </a>
        @else
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'librarian')
                <a href="{{ route('admin.dashboard') }}"
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition">
                    Go to Dashboard
                </a>
            @elseif(auth()->user()->role === 'member')
                <a href="{{ route('user.dashboard') }}"
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition">
                    Go to Dashboard
                </a>
            @endif
        @endguest
    </div>

    <!-- Extra section -->
    <div class="mt-10 text-gray-500 dark:text-gray-400 text-sm">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} — PHP v{{ PHP_VERSION }}
    </div>
</div>
@endsection
