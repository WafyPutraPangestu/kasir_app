<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Table;
use Illuminate\Support\Facades\Session;

class CustomerMenuController extends Controller
{
    public function showMenuForTable(string $qr_token)
    {
        $table = Table::where('qr_token', $qr_token)->firstOrFail();

        // Simpan table_id dan table_name di session
        Session::put('table_id', $table->id);
        Session::put('table_name', $table->name);

        $categories = Category::with(['products' => function ($query) {
            $query->where('is_active', true)->where('is_available', true);
        }])->get();

        return view('customer.menu', compact('table', 'categories'));
    }
}
