<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // Display a list of authors
    public function index()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }

    // Show form to create a new author
    public function create()
    {
        return view('authors.create');
    }

    // Store new author
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Author::create($request->only('name'));

        return redirect()->route('authors.index')->with('success', 'Author created successfully.');
    }

    // Show form to edit an author
    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    // Update author
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author->update($request->only('name'));

        return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
    }

    // Delete author
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
    }
}
