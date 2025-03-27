<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $category = Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', "Category <b>{$category->name}</b> created successfully.");
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->only('name'));

        return redirect()->route('admin.categories.index')->with('success', "Category <b>{$category->name}</b> updated successfully.");
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', "Category <b>{$category->name}</b> deleted successfully.");
    }

}
