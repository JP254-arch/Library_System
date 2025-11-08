@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Add Category</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <label class="block mb-2">Category Name</label>
        <input type="text" name="name" class="border px-3 py-2 w-full mb-4" required>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
    </form>
</div>
@endsection
