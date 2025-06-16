<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TableController extends Controller
{
    /**
     * Display a listing of tables.
     */
    public function tableindex()
    {
        $tables = Table::latest()->simplePaginate(5); // Paginate 5 tables per page
        return view('admin.table-index', compact('tables'));
    }

    /**
     * Show the form for creating a new table.
     */
    public function tablecreate()
    {
        return view('admin.create-table');
    }

    /**
     * Store a newly created table in storage.
     */
    public function tablestore(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tables,name',
        ], []);

        // Create new table
        Table::create([
            'name' => $validated['name'],
            'status' => 'available',
            'qr_token' => Str::random(32),
        ]);

        // Redirect with success message
        return redirect()->route('admin.tables.index')
            ->with('success', 'Meja ' . $validated['name'] . ' berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified table.
     */
    public function edit(Table $table)
    {
        return view('admin.edit-table', compact('table'));
    }

    /**
     * Update the specified table in storage.
     */
    public function update(Request $request, Table $table)
    {
        // Validate input, allowing the current table's name
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tables,name,' . $table->id,
            'status' => 'required|in:available',
        ]);

        // Update table
        $table->update([
            'name' => $validated['name'],
            'status' => $validated['status'],
        ]);

        // Redirect with success message
        return redirect()->route('admin.tables.index')
            ->with('success', 'Meja ' . $validated['name'] . ' berhasil diperbarui.');
    }

    /**
     * Remove the specified table from storage.
     */
    public function destroy(Table $table)
    {
        // Store table name for success message
        $tableName = $table->name;

        // Delete table
        $table->delete();

        // Redirect with success message
        return redirect()->route('admin.tables.index')
            ->with('success', 'Meja ' . $tableName . ' berhasil dihapus.');
    }
}
