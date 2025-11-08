@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-3xl">
    <h1 class="text-3xl font-bold mb-6 text-indigo-600 text-center">
        {{ isset($book) ? '✏️ Edit Book' : '➕ Add New Book' }}
    </h1>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($book) ? route('books.update', $book->id) : route('books.store') }}"
          method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-2xl shadow-md">
        @csrf
        @if(isset($book))
            @method('PUT')
        @endif

        {{-- Title --}}
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
            <input type="text" name="title" id="title"
                   value="{{ old('title', $book->title ?? '') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        {{-- ISBN --}}
        <div class="mb-4">
            <label for="isbn" class="block text-gray-700 font-medium mb-2">ISBN</label>
            <input type="text" name="isbn" id="isbn"
                   value="{{ old('isbn', $book->isbn ?? '') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        {{-- Author --}}
        <div class="mb-4">
            <label for="author_id" class="block text-gray-700 font-medium mb-2">Author</label>
            <select name="author_id" id="author_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Select Author --</option>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}"
                        {{ old('author_id', $book->author_id ?? '') == $author->id ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Category --}}
        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 font-medium mb-2">Category</label>
            <select name="category_id" id="category_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $book->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $book->description ?? '') }}</textarea>
        </div>

        {{-- Total Copies --}}
        <div class="mb-4">
            <label for="total_copies" class="block text-gray-700 font-medium mb-2">Total Copies</label>
            <input type="number" name="total_copies" id="total_copies" min="1"
                   value="{{ old('total_copies', $book->total_copies ?? '') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        {{-- Published At --}}
        <div class="mb-4">
            <label for="published_at" class="block text-gray-700 font-medium mb-2">Published Date</label>
            <input type="date" name="published_at" id="published_at"
                   value="{{ old('published_at', isset($book->published_at) ? $book->published_at->format('Y-m-d') : '') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        {{-- Cover --}}
        <div class="mb-6">
            <label for="cover" class="block text-gray-700 font-medium mb-2">Book Cover</label>
            <input type="file" name="cover" id="cover"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">

            @if(isset($book) && $book->cover)
                <img src="{{ $book->cover['type'] === 'upload' ? asset('storage/' . $book->cover['path']) : $book->cover['path'] }}"
                     alt="Cover" class="mt-4 w-32 h-40 object-cover rounded-lg shadow-sm">
            @endif
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-lg transition">
                {{ isset($book) ? '💾 Update Book' : '➕ Add Book' }}
            </button>
        </div>
    </form>
</div>
@endsection
