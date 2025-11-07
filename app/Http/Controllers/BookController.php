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

        // Fetch books
        $booksQuery = Book::with('author', 'category')
            ->when($q, fn($qb) => $qb
                ->where('title', 'like', "%{$q}%")
                ->orWhere('isbn', 'like', "%{$q}%"))
            ->latest();

        // If root URL, limit to 6 for home page
        if ($request->path() === '/') {
            $books = $booksQuery->take(6)->get();
            return view('home', compact('books'));
        }

        // Otherwise, paginate for listing page
        $books = $booksQuery->paginate(12);
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
            $path = $request->file('cover')->store('covers', 'public');
            $data['cover'] = [
                'type' => 'upload',
                'path' => $path,
            ];
        }

        $data['available_copies'] = $data['total_copies'];

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
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
            $path = $request->file('cover')->store('covers', 'public');
            $data['cover'] = [
                'type' => 'upload',
                'path' => $path,
            ];
        }

        $diff = $data['total_copies'] - $book->total_copies;
        if ($diff !== 0) {
            $book->available_copies += $diff;
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return back()->with('success', 'Book deleted successfully!');
    }
}
