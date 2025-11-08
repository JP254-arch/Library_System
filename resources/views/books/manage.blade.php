@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold mb-6 text-indigo-600 text-center">📚 Manage Books</h1>

        {{-- Add Book Button --}}
        <div class="flex justify-end mb-6">
            <a href="{{ route('books.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition">
                ➕ Add New Book
            </a>
        </div>

        {{-- Search Form --}}
        <form method="GET" action="{{ route('books.manage') }}" class="mb-6 flex justify-center space-x-2">
            <select name="search_by"
                class="border rounded-l-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="all" {{ request('search_by') === 'all' ? 'selected' : '' }}>All</option>
                <option value="title" {{ request('search_by') === 'title' ? 'selected' : '' }}>Title</option>
                <option value="category" {{ request('search_by') === 'category' ? 'selected' : '' }}>Category</option>
            </select>

            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..."
                class="border-t border-b border-l px-4 py-2 w-80 focus:outline-none focus:ring-2 focus:ring-indigo-500">

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-lg hover:bg-indigo-700 transition">
                Search
            </button>
        </form>

        @if ($books->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase">
                        <tr>
                            <th class="py-3 px-4 text-left">Title</th>
                            <th class="py-3 px-4 text-left">Author</th>
                            <th class="py-3 px-4 text-left">Category</th>
                            <th class="py-3 px-4 text-left">Available Copies</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $book->title }}</td>
                                <td class="py-3 px-4">{{ $book->author->name ?? 'Unknown' }}</td>
                                <td class="py-3 px-4">{{ $book->category->name ?? 'Uncategorized' }}</td>
                                <td class="py-3 px-4">{{ $book->available_copies ?? 0 }}</td>
                                <td class="py-3 px-4 space-x-2">
                                    <a href="{{ route('books.edit', $book->id) }}"
                                        class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-medium px-3 py-1 rounded transition">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this book?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-xs font-medium px-3 py-1 rounded transition">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                {{ $books->appends(['q' => request('q'), 'search_by' => request('search_by')])->links() }}
            </div>
        @else
            <p class="text-gray-500 text-center">No books found.</p>
        @endif
    </div>
@endsection
