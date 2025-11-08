@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="bg-indigo-500 text-white py-20 rounded-3xl shadow-lg mx-4 md:mx-0">
        <div class="container mx-auto text-center px-4">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Lexicon Logo"
                    class="h-40 w-40 rounded-full shadow-[0_0_25px_5px_rgba(255,0,102,0.6)] ring-4 ring-pink-400 ring-opacity-50 transition-all duration-500 hover:shadow-[0_0_45px_10px_rgba(255,0,102,0.8)]">
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to Lexicon</h1>
            <p class="text-lg md:text-xl mb-8">
                Your gateway to endless learning — explore, discover, and be inspired by books and ideas that shape the
                future.
            </p>
            <a href="#featured-books"
                class="bg-white text-indigo-600 font-semibold px-6 py-3 rounded-lg shadow hover:bg-gray-100">
                Explore Books
            </a>
        </div>
    </section>

    <!-- Featured Books -->
    <section id="featured-books" class="py-16 container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-10 text-indigo-600">Featured Books</h2>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse ($books->take(3) as $book)
                @php
                    $coverData = $book->cover ?? null;

                    if (is_array($coverData)) {
                        if (($coverData['type'] ?? null) === 'upload' && !empty($coverData['path'])) {
                            $coverUrl = asset('storage/' . ltrim($coverData['path'], '/'));
                        } elseif (($coverData['type'] ?? null) === 'url' && !empty($coverData['path'])) {
                            $coverUrl = $coverData['path'];
                        } else {
                            $coverUrl = asset('images/default-cover.jpg');
                        }
                    } else {
                        $coverUrl = asset('images/default-cover.jpg');
                    }
                @endphp

                <div class="bg-white shadow-md rounded-2xl overflow-hidden hover:shadow-lg transition">
                    <img src="{{ $coverUrl }}" alt="{{ $book->title }}"
                        class="w-full h-48 object-cover {{ $coverUrl === asset('images/default-cover.jpg') ? 'opacity-70' : '' }}">
                    <div class="p-5">
                        <h4 class="text-xl font-semibold mb-2 text-gray-800">{{ $book->title }}</h4>
                        <p class="text-gray-600 mb-4">by {{ $book->author->name ?? 'Unknown Author' }}</p>
                        <a href="{{ route('books.show', $book->id) }}"
                            class="text-indigo-600 font-semibold hover:underline">
                            View Details →
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center col-span-3">No featured books available at the moment.</p>
            @endforelse
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('books.index') }}" class="text-indigo-600 font-semibold hover:underline">
                View All Books →
            </a>
        </div>
    </section>

    <!-- Popular Categories-->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-3xl font-bold mb-10 text-teal-700">Popular Categories</h3>

            <div class="flex flex-wrap justify-center gap-4">
                @forelse ($categories as $category)
                    <a href="{{ route('books.index', ['category' => $category->id]) }}"
                        class="bg-white px-6 py-3 rounded-full shadow-md text-gray-700 font-medium
                          hover:bg-gradient-to-r hover:from-indigo-200 hover:to-pink-200
                          hover:text-fuchsia-900 hover:shadow-xl
                          transform hover:-translate-y-1 hover:rotate-1
                          transition-all duration-300 ease-in-out animate-hover-wave">
                        {{ $category->name }}
                    </a>
                @empty
                    <p class="text-gray-500">No categories available.</p>
                @endforelse
            </div>
        </div>
    </section>

    <style>
        @keyframes hoverWave {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-3px) rotate(1deg);
            }
        }

        .animate-hover-wave:hover {
            animation: hoverWave 0.4s ease-in-out;
        }
    </style>


    <!-- Auth Buttons -->
    <div class="flex flex-wrap justify-center gap-4 mt-10">
        @guest
            <a href="{{ route('login') }}"
                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition">Login</a>
            <a href="{{ route('register') }}"
                class="px-6 py-3 border border-indigo-500 text-indigo-600 hover:bg-indigo-50 rounded-xl font-semibold transition">Register</a>
        @else
            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'librarian')
                <a href="{{ route('admin.dashboard') }}"
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition">Go
                    to Dashboard</a>
            @elseif(auth()->user()->role === 'member')
                <a href="{{ route('user.dashboard') }}"
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition">Go
                    to Dashboard</a>
            @endif
        @endguest
    </div>
@endsection
