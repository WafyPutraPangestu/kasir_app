<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori.
     */
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255|unique:categories,name',
            ],
            [
                'name.required' => 'Nama kategori harus diisi.',
                'name.unique' => 'Kategori dengan nama ini sudah ada.',
                'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            ]
        );
        $validated['slug'] = Str::slug($validated['name']);
        Category::create($validated);
        return redirect()->route('admin.category.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit kategori.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }


    /**
     * Memperbarui data kategori.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ], [
            'name.required' => 'Nama kategori harus diisi.',
            'name.unique' => 'Kategori dengan nama ini sudah ada.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        $category->update($validated);
        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori.
     */
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk terkait.');
        }
        $category->delete();
        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
