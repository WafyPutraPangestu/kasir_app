<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TableController extends Controller
{
    public function tableindex()
    {
        $tables = Table::latest()->get(); // Ambil semua data meja, urutkan dari yang terbaru
        return view('admin.table-index', compact('tables'));
    }
    public function tablecreate()
    {
        return view('admin.create-table'); // Tampilkan form untuk menambahkan meja baru
    }

    public function tablestore(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tables,name',
        ]);

        // 2. Buat data meja baru
        Table::create([
            'name' => $validated['name'],
            'status' => 'available', // Status default
            'qr_token' => Str::random(32), // 3. Generate token unik untuk QR Code
        ]);

        // 4. Redirect kembali ke halaman daftar meja dengan pesan sukses
        return redirect()->route('admin.table-index')
            ->with('success', 'Meja ' . $validated['name'] . ' berhasil ditambahkan.');
    }
}
