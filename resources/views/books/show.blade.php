@extends('layouts.app')

@section('content')
  <div class="bg-white p-4 rounded shadow">
    <h2 class="font-bold text-xl">{{ $book->title }}</h2>
    <p>Author: {{ $book->author->name ?? 'Unknown' }}</p>
    <p>Category: {{ $book->category->name ?? 'Uncategorized' }}</p>
    <p>{{ $book->description }}</p>
    <p>Available: {{ $book->available_copies }}</p>
  </div>
@endsection
