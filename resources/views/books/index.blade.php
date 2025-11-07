@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-8 text-indigo-600 text-center">All Books</h1>

    @auth
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
                        <p class="text-gray-500 text-sm mb-2">Category: {{ $book->category->name ?? 'Uncategorized' }}</p>
                        <a href="{{ route('books.show', $book->id) }}" class="text-indigo-600 font-semibold hover:underline">
                            View Details →
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center col-span-3">No books available at the moment.</p>
            @endforelse
        </div>

        <div class="mt-8 flex justify-center">
            {{ $books->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-gray-500 text-lg">You must <a href="{{ route('login') }}" class="text-indigo-600 underline">login</a> to view all books.</p>
        </div>
    @endauth
</div>
@endsection
