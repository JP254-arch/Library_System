@extends('layouts.app')

@section('content')
  <h2 class="font-bold text-xl mb-4">Add Book</h2>
  <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-2">
      <label>Title</label>
      <input name="title" class="border p-2 w-full" required>
    </div>
    <div class="mb-2">
      <label>ISBN</label>
      <input name="isbn" class="border p-2 w-full">
    </div>
    <div class="mb-2">
      <label>Author</label>
      <select name="author_id" class="border p-2 w-full">
        <option value="">--</option>
        @foreach($authors as $a)
          <option value="{{ $a->id }}">{{ $a->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-2">
      <label>Category</label>
      <select name="category_id" class="border p-2 w-full">
        <option value="">--</option>
        @foreach($categories as $c)
          <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-2">
      <label>Total copies</label>
      <input name="total_copies" type="number" min="1" value="1" class="border p-2 w-full" required>
    </div>
    <div class="mb-2">
      <label>Cover</label>
      <input name="cover" type="file" class="border p-2 w-full">
    </div>
    <button class="p-2 bg-blue-600 text-white">Create</button>
  </form>
@endsection
