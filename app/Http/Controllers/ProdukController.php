<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     */
    public function index()
    {
        // Mengambil produk dengan relasi kategori untuk efisiensi (Eager Loading)
        $products = Product::with('category')->latest()->simplePaginate('5');
        return view('admin.produk.index', compact('products'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        // Mengambil semua kategori untuk ditampilkan di dropdown
        $categories = Category::all();
        return view('admin.produk.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru ke database.
     */
    // Ganti seluruh method 'store' Anda dengan ini:
    public function store(Request $request)
    {
        // 1. Validasi data input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required' => 'Nama produk harus diisi.',
            'category_id.required' => 'Kategori produk harus dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'price.required' => 'Harga produk harus diisi.',
            'price.integer' => 'Harga harus berupa angka bulat.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, gif, atau webp.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'image.dimensions' => 'Gambar harus memiliki dimensi yang valid.',

        ]);

        // 2. Handle upload gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // 3. Tambahkan nilai boolean dari checkbox secara eksplisit
        // Metode $request->boolean() akan mengembalikan `true` jika checkbox dicentang,
        // dan `false` jika tidak ada atau nilainya '0', 'false', dll.
        $validated['is_available'] = $request->boolean('is_available');
        $validated['is_active'] = $request->boolean('is_active');

        // 4. Simpan ke database
        Product::create($validated);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.produk.edit', compact('product', 'categories'));
    }

    /**
     * Memperbarui data produk di database.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
                'price' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'is_available' => 'sometimes|boolean',
                'is_active' => 'sometimes|boolean',
            ],
            [
                'name.required' => 'Nama produk harus diisi.',
                'category_id.required' => 'Kategori produk harus dipilih.',
                'category_id.exists' => 'Kategori yang dipilih tidak valid.',
                'description.string' => 'Deskripsi harus berupa teks.',
                'price.required' => 'Harga produk harus diisi.',
                'price.integer' => 'Harga harus berupa angka bulat.',
                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, gif, atau webp.',
                'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
                'image.dimensions' => 'Gambar harus memiliki dimensi yang valid.',

            ]
        );

        // Handle upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['is_available'] = $request->has('is_available');
        $validated['is_active'] = $request->has('is_active');

        $product->update($validated);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Product $product)
    {
        // Hapus gambar dari storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
