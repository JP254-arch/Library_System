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
        // Allow public access to browsing & searching books
        $this->middleware(['auth', 'role:librarian|admin'])->except(['index', 'show', 'search']);
    }

    /**
     * Display a list of books (with optional search & category filters)
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $categoryId = $request->query('category');

        $booksQuery = Book::with(['author', 'category'])
            ->when(
                $q,
                fn($qb) => $qb
                    ->where('title', 'like', "%{$q}%")
                    ->orWhereHas('category', fn($qb2) => $qb2->where('name', 'like', "%{$q}%"))
                    ->orWhereHas('author', fn($qb3) => $qb3->where('name', 'like', "%{$q}%"))
            )
            ->when($categoryId, fn($qb) => $qb->where('category_id', $categoryId))
            ->orderBy('title', 'asc');

        // If the request is for the homepage
        if ($request->path() === '/') {
            $books = Book::with('author', 'category')->inRandomOrder()->take(3)->get();
            $categories = Category::orderBy('name', 'asc')->get();
            return view('home', compact('books', 'categories'));
        }

        $books = $booksQuery->paginate(12);
        $categories = Category::orderBy('name', 'asc')->get();

        return view('books.index', compact('books', 'categories', 'q', 'categoryId'));
    }

    /**
     * Live search API for autocomplete
     */
    public function search(Request $request)
    {
        $q = $request->query('q');

        $books = Book::with('author', 'category')
            ->when(
                $q,
                fn($qb) => $qb
                    ->where('title', 'like', "%{$q}%")
                    ->orWhereHas('category', fn($qb2) => $qb2->where('name', 'like', "%{$q}%"))
                    ->orWhereHas('author', fn($qb3) => $qb3->where('name', 'like', "%{$q}%"))
            )
            ->limit(10)
            ->get();

        return response()->json(
            $books->map(fn($book) => [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author->name ?? 'Unknown',
                'category' => $book->category->name ?? 'Uncategorized',
            ])
        );
    }

    /**
     * Show the form to create a new book
     */
    public function create()
    {
        $authors = Author::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        return view('books.form', compact('authors', 'categories'));
    }

    /**
     * Store a new book
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
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
            $data['cover'] = ['type' => 'upload', 'path' => $path];
        }

        $data['available_copies'] = $data['total_copies'];

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    /**
     * Display a single book
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the edit form for a specific book
     */
    public function edit(Book $book)
    {
        $authors = Author::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        return view('books.form', compact('book', 'authors', 'categories'));
    }

    /**
     * Update an existing book
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
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
            $data['cover'] = ['type' => 'upload', 'path' => $path];
        }

        // Adjust available copies if total copies changed
        $diff = $data['total_copies'] - $book->total_copies;
        if ($diff !== 0) {
            $book->available_copies += $diff;
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    /**
     * Delete a book
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return back()->with('success', 'Book deleted successfully!');
    }
}
