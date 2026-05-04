<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('documents');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(10)->withQueryString();

        // Separate full collection for stat cards (always top 5 regardless of page)
        $statCategories = Category::withCount('documents')->latest()->get();

        return view('categories.index', compact('categories', 'statCategories'));
    }

    public function create()
    {
        $existing = Category::latest()->get();
        return view('categories.create-page', compact('existing'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
            'color'       => 'required|in:blue,green,yellow,red,purple,pink,indigo,orange',
            'status'      => 'required|in:active,inactive',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('notify', [
                'message' => 'Category "' . $validated['name'] . '" created successfully.',
                'type'    => 'success',
            ]);
    }

    public function edit(Category $category)
    {
        $existing = Category::where('id', '!=', $category->id)->latest()->get();
        return view('categories.update', compact('category', 'existing'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'color'       => 'required|in:blue,green,yellow,red,purple,pink,indigo,orange',
            'status'      => 'required|in:active,inactive',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('notify', [
                'message' => 'Category "' . $validated['name'] . '" updated successfully.',
                'type'    => 'success',
            ]);
    }
    
    public function destroy(Category $category)
    {
        $name = $category->name;
        $category->delete();

        return redirect()->route('categories.index')
            ->with('notify', [
                'message' => 'Category "' . $name . '" deleted successfully.',
                'type'    => 'success',
            ]);
    }
}