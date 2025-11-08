@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Edit Author</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('authors.update', $author) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block mb-1 font-semibold">Author Name</label>
            <input type="text" name="name" id="name" value="{{ $author->name }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">Update Author</button>
    </form>
</div>
@endsection
