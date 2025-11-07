@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-indigo-600 text-white py-20">
    <div class="container mx-auto text-center px-4">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Lexicon Logo" class="h-20 w-20 rounded-full shadow-md">
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to Lexicon</h1>
        <p class="text-lg md:text-xl mb-8">
            Discover and explore books, stories, and insights that inspire learning and creativity.
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
        @forelse ($books as $book)
            @php
                // Unified cover logic
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
                <img src="{{ $coverUrl }}"
                     alt="{{ $book->title }}"
                     class="w-full h-48 object-cover {{ $coverUrl === asset('images/default-cover.jpg') ? 'opacity-70' : '' }}">
                <div class="p-5">
                    <h4 class="text-xl font-semibold mb-2 text-gray-800">{{ $book->title }}</h4>
                    <p class="text-gray-600 mb-4">by {{ $book->author->name ?? 'Unknown Author' }}</p>
                    <a href="{{ route('books.show', $book->id) }}" class="text-indigo-600 font-semibold hover:underline">
                        View Details →
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center col-span-3">No featured books available at the moment.</p>
        @endforelse
    </div>

    @if($books->count() > 0)
        <div class="text-center mt-8">
            <a href="{{ route('books.index') }}" class="text-indigo-600 font-semibold hover:underline">
                View All Books →
            </a>
        </div>
    @endif
</section>

<!-- Popular Categories -->
<section class="bg-gray-100 py-16">
    <div class="container mx-auto px-4 text-center">
        <h3 class="text-3xl font-bold mb-10">Popular Categories</h3>
        <div class="flex flex-wrap justify-center gap-4">
            <span class="bg-white px-6 py-3 rounded-full shadow hover:bg-indigo-50 hover:text-indigo-600 cursor-pointer">Fiction</span>
            <span class="bg-white px-6 py-3 rounded-full shadow hover:bg-indigo-50 hover:text-indigo-600 cursor-pointer">Technology</span>
            <span class="bg-white px-6 py-3 rounded-full shadow hover:bg-indigo-50 hover:text-indigo-600 cursor-pointer">Education</span>
            <span class="bg-white px-6 py-3 rounded-full shadow hover:bg-indigo-50 hover:text-indigo-600 cursor-pointer">Travel</span>
            <span class="bg-white px-6 py-3 rounded-full shadow hover:bg-indigo-50 hover:text-indigo-600 cursor-pointer">Health</span>
        </div>
    </div>
</section>

<!-- Auth Buttons -->
<div class="flex flex-wrap justify-center gap-4 mt-10">
    @guest
        <a href="{{ route('login') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition">Login</a>
        <a href="{{ route('register') }}" class="px-6 py-3 border border-indigo-500 text-indigo-600 hover:bg-indigo-50 rounded-xl font-semibold transition">Register</a>
    @else
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'librarian')
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition">Go to Dashboard</a>
        @elseif(auth()->user()->role === 'member')
            <a href="{{ route('user.dashboard') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition">Go to Dashboard</a>
        @endif
    @endguest
</div>

<!-- Footer Info -->
<div class="mt-10 text-gray-500 text-center text-sm">
    Laravel v{{ Illuminate\Foundation\Application::VERSION }} — PHP v{{ PHP_VERSION }}
</div>
@endsection
