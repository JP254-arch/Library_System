@extends('layouts.app')

@section('content')
  <h1 class="font-bold text-xl">My Loans</h1>
  <ul>
    @foreach($loans as $loan)
      <li>{{ $loan->book->title }} - {{ $loan->status }} - Due: {{ $loan->due_at?->format('Y-m-d') }}</li>
    @endforeach
  </ul>
  {{ $loans->links() }}
@endsection
