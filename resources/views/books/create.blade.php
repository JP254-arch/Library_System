@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl md:text-4xl font-bold text-indigo-600 mb-8 text-center">Add a New Book</h1>

    <div class="bg-white shadow-lg rounded-2xl p-8 max-w-2xl mx-auto">
        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 rounded-md text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Title --}}
            <div>
                <label for="title" class="block font-semibold text-gray-700 mb-1">Book Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
            </div>

            {{-- ISBN --}}
            <div>
                <label for="isbn" class="block font-semibold text-gray-700 mb-1">ISBN</label>
                <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            {{-- Author --}}
            <div>
                <label for="author_id" class="block font-semibold text-gray-700 mb-1">Author</label>
                <select name="author_id" id="author_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Select an author</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}" @selected(old('author_id') == $author->id)>{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Category --}}
            <div>
                <label for="category_id" class="block font-semibold text-gray-700 mb-1">Category</label>
                <select name="category_id" id="category_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            {{-- Total Copies --}}
            <div>
                <label for="total_copies" class="block font-semibold text-gray-700 mb-1">Total Copies <span class="text-red-500">*</span></label>
                <input type="number" name="total_copies" id="total_copies" value="{{ old('total_copies') ?? 1 }}" min="1"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
            </div>

            {{-- Published Date --}}
            <div>
                <label for="published_at" class="block font-semibold text-gray-700 mb-1">Published Date</label>
                <input type="date" name="published_at" id="published_at" value="{{ old('published_at') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            {{-- Cover Upload --}}
            <div>
                <label for="cover" class="block font-semibold text-gray-700 mb-1">Book Cover</label>
                <input type="file" name="cover" id="cover" accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            {{-- Submit Button --}}
            <div class="text-center">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-xl shadow-md transition">
                    Add Book
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
