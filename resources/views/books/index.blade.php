@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold mb-6 text-indigo-600 text-center">All Books</h1>

        {{-- Search Form --}}
        <form method="GET" action="{{ route('books.index') }}" class="mb-6 flex justify-center space-x-2">
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

        @auth
            <div class="grid md:grid-cols-3 gap-8">
                @forelse($books as $book)
                    @php
                        $coverData = $book->cover ?? null;
                        $coverUrl =
                            is_array($coverData) && !empty($coverData['path'])
                                ? ($coverData['type'] === 'upload'
                                    ? asset('storage/' . ltrim($coverData['path'], '/'))
                                    : $coverData['path'])
                                : asset('images/default-cover.jpg');

                        $loan = auth()
                            ->user()
                            ->loans()
                            ->where('book_id', $book->id)
                            ->where('status', 'borrowed')
                            ->first();

                        $highlight = request('q');
                        $searchBy = request('search_by', 'all');

                        $titleHighlighted =
                            $highlight && ($searchBy === 'title' || $searchBy === 'all')
                                ? preg_replace("/($highlight)/i", '<span class="bg-yellow-200">$1</span>', $book->title)
                                : $book->title;

                        $categoryHighlighted = $book->category
                            ? ($highlight && ($searchBy === 'category' || $searchBy === 'all')
                                ? preg_replace(
                                    "/($highlight)/i",
                                    '<span class="bg-yellow-200">$1</span>',
                                    $book->category->name,
                                )
                                : $book->category->name)
                            : 'Uncategorized';
                    @endphp

                    <div class="bg-white shadow-md rounded-2xl overflow-hidden hover:shadow-lg transition flex flex-col">
                        <img src="{{ $coverUrl }}" alt="{{ $book->title }}"
                            class="w-full h-48 object-cover {{ $coverUrl === asset('images/default-cover.jpg') ? 'opacity-70' : '' }}">
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="text-xl font-semibold mb-2 text-gray-800">{!! $titleHighlighted !!}</h4>
                                <p class="text-gray-600 mb-2">by {{ $book->author->name ?? 'Unknown Author' }}</p>
                                <p class="text-gray-500 text-sm mb-4">Category: {!! $categoryHighlighted !!}</p>
                            </div>

                            <div class="mt-2 flex flex-col space-y-2">
                                <a href="{{ route('books.show', $book->id) }}"
                                    class="text-indigo-600 font-semibold hover:underline">
                                    View Details →
                                </a>

                                {{-- Member Borrow/Return Buttons --}}
                                @if (auth()->user()->role === 'member')
                                    @if ($loan)
                                        @php
                                            $totalDays = $loan->due_at->diffInDays($loan->borrowed_at);
                                            $daysLeft = now()->diffInDays($loan->due_at, false);
                                            $buttonColor =
                                                $daysLeft / $totalDays > 0.66
                                                    ? 'bg-green-600 hover:bg-green-700'
                                                    : ($daysLeft / $totalDays > 0.33
                                                        ? 'bg-orange-500 hover:bg-orange-600'
                                                        : 'bg-red-600 hover:bg-red-700');
                                        @endphp
                                        <form action="{{ route('loans.return', $book->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-full px-4 py-2 text-white rounded-lg transition {{ $buttonColor }}">
                                                Return
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('loans.borrow', $book->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                                Borrow
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                {{-- Admin/Librarian Edit & Delete --}}
                                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'librarian')
                                    <div class="flex space-x-2 mt-2">
                                        <a href="{{ route('books.edit', $book->id) }}"
                                            class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-white text-sm font-medium px-3 py-2 rounded transition text-center">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="flex-1"
                                            onsubmit="return confirm('Are you sure you want to delete this book?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-3 py-2 rounded transition">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center col-span-3">No books available at the moment.</p>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-8 flex justify-center">
                {{ $books->appends(['q' => request('q'), 'search_by' => request('search_by')])->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-gray-500 text-lg">You must <a href="{{ route('login') }}"
                        class="text-indigo-600 underline">login</a> to view all books.</p>
            </div>
        @endauth
    </div>
@endsection
