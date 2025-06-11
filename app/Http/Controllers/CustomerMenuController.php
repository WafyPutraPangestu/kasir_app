<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Table;
use Illuminate\Http\Request;

class CustomerMenuController extends Controller
{
    /**
     * Menampilkan menu produk untuk meja tertentu berdasarkan qr_token.
     */
    public function showMenuForTable(string $qr_token)
    {
        // 1. Cari meja berdasarkan token uniknya. Jika tidak ada, tampilkan 404 Not Found.
        $table = Table::where('qr_token', $qr_token)->firstOrFail();

        // 2. Ambil semua kategori beserta produk-produk di dalamnya yang berstatus 'is_active'
        //    Ini menggunakan Eager Loading untuk performa yang lebih baik.
        $categories = Category::with(['products' => function ($query) {
            $query->where('is_active', true)->where('is_available', true);
        }])->get();

        // 3. Kirim data meja dan kategori ke view
        return view('customer.menu', compact('table', 'categories'));
    }
}
