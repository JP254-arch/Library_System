@extends('layouts.app')

@section('content')
  <h1 class="font-bold text-xl">Loans</h1>
  <table class="min-w-full bg-white">
    <thead><tr><th>User</th><th>Book</th><th>Status</th><th>Due</th></tr></thead>
    <tbody>
      @foreach($loans as $loan)
        <tr>
          <td>{{ $loan->user->name }}</td>
          <td>{{ $loan->book->title }}</td>
          <td>{{ $loan->status }}</td>
          <td>{{ $loan->due_at?->format('Y-m-d') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $loans->links() }}
@endsection
