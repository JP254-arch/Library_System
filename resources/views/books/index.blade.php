@extends('layouts.app')

@section('content')
  <form method="GET" action="{{ route('home') }}" class="mb-4">
    <input name="q" placeholder="Search books..." value="{{ $q ?? '' }}" class="border p-2" />
    <button class="p-2 bg-blue-500 text-white">Search</button>
  </form>

  <div class="grid grid-cols-3 gap-4">
    @foreach($books as $book)
      <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold">{{ $book->title }}</h3>
        <p>Author: {{ $book->author->name ?? 'Unknown' }}</p>
        <p>Available: {{ $book->available_copies }}</p>

        <a href="{{ route('books.show', $book) }}" class="text-blue-600">View</a>

        @auth
          @if(auth()->user()->role === 'member' && $book->available_copies > 0)
            <form method="POST" action="{{ route('loans.borrow', $book) }}">@csrf
              <button type="submit" class="mt-2 p-2 bg-green-500 text-white">Borrow</button>
            </form>
          @endif
        @endauth
      </div>
    @endforeach
  </div>

  <div class="mt-6">{{ $books->withQueryString()->links() }}</div>
@endsection
