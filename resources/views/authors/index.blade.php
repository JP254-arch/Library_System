@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Authors</h1>

    <a href="{{ route('authors.create') }}" class="inline-block mb-4 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
        ➕ Add Author
    </a>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    @if($authors->count() > 0)
        <table class="min-w-full border border-gray-200 rounded-lg text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase">
                <tr>
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Name</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($authors as $author)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $author->id }}</td>
                        <td class="py-3 px-4">{{ $author->name }}</td>
                        <td class="py-3 px-4 space-x-2">
                            <a href="{{ route('authors.edit', $author) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">Edit</a>
                            <form action="{{ route('authors.destroy', $author) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600">No authors available.</p>
    @endif
</div>
@endsection
