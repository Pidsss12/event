<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = EventCategory::withCount('events')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:event_categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        EventCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon ?: 'tag', // Fallback icon
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(EventCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, EventCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:event_categories,name,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon ?: 'tag',
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(EventCategory $category)
    {
        if ($category->events()->count() > 0) {
            return back()->with('error', 'Cannot delete category because it has active events.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
