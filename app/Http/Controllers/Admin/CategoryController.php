<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // READ
        public function index(Request $request)
    {
        $search = $request->search;

        $categories = Category::when($search, function ($query) use ($search) {

            $query->where('name', 'LIKE', '%' . $search . '%');

        })->latest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    // CREATE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) // AUTO SLUG
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan');
    }

    // UPDATE
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:2'
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name) // update slug juga
        ]);

        return back()->with('success', 'Kategori berhasil diupdate');
    }

    // DELETE
    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }
}
