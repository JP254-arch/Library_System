@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Book</h1>

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $book->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="author_id" class="form-label">Author</label>
            <select name="author_id" id="author_id" class="form-control">
                <option value="">Select author</option>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">Select category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="total_copies" class="form-label">Total Copies</label>
            <input type="number" name="total_copies" id="total_copies" class="form-control" value="{{ old('total_copies', $book->total_copies) }}" min="1" required>
        </div>

        <div class="mb-3">
            <label for="cover" class="form-label">Cover Image</label>
            <input type="file" name="cover" id="cover" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Book</button>
    </form>
</div>
@endsection
