<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // List all categories (alphabetically)
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get(); // ✅ alphabetical order
        return view('categories.index', compact('categories'));
    }

    // Show form to create a new category
    public function create()
    {
        return view('categories.create');
    }

    // Store new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);

        Category::create(['name' => ucfirst(strtolower($request->name))]); // ✅ normalize case
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    // Show form to edit a category
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Update category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id,
        ]);

        $category->update(['name' => ucfirst(strtolower($request->name))]); // ✅ consistent naming
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    // Delete category
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
