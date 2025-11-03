<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:librarian|admin'])->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $q = $request->query('q');
        $books = Book::with('author', 'category')
            ->when($q, fn($qb) => $qb->where('title', 'like', "%{$q}%")->orWhere('isbn', 'like', "%{$q}%"))
            ->paginate(12);

        return view('books.index', compact('books', 'q'));
    }

    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'isbn' => 'nullable|string|unique:books,isbn',
            'author_id' => 'nullable|exists:authors,id',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'total_copies' => 'required|integer|min:1',
            'cover' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }
        $data['available_copies'] = $data['total_copies'];
        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Book added');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'isbn' => 'nullable|string|unique:books,isbn,' . $book->id,
            'author_id' => 'nullable|exists:authors,id',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'total_copies' => 'required|integer|min:1',
            'cover' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        // adjust available copies if total changed
        $diff = $data['total_copies'] - $book->total_copies;
        if ($diff !== 0) {
            $book->available_copies += $diff;
        }

        $book->update($data);
        return redirect()->route('books.index')->with('success', 'Updated');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return back()->with('success', 'Deleted');
    }
}
