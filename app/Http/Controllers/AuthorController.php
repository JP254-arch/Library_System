<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(){ $authors = Author::paginate(20); return view('authors.index', compact('authors')); }
    public function create(){ return view('authors.create'); }
    public function store(Request $r){ Author::create($r->validate(['name'=>'required'])); return redirect()->route('authors.index'); }
    public function edit(Author $author){ return view('authors.edit', compact('author')); }
    public function update(Request $r, Author $author){ $author->update($r->validate(['name'=>'required'])); return redirect()->route('authors.index'); }
    public function destroy(Author $author){ $author->delete(); return back(); }
}
