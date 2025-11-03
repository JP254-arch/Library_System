<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){ $items = Category::paginate(20); return view('categories.index', ['categories'=>$items]); }
    public function create(){ return view('categories.create'); }
    public function store(Request $r){ Category::create($r->validate(['name'=>'required'])); return redirect()->route('categories.index'); }
    public function edit(Category $category){ return view('categories.edit', compact('category')); }
    public function update(Request $r, Category $category){ $category->update($r->validate(['name'=>'required'])); return redirect()->route('categories.index'); }
    public function destroy(Category $category){ $category->delete(); return back(); }
}
