<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\Table;
use App\Models\Category;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik umum
        $totalTables = Table::count();
        $totalProducts = Product::where('is_active', true)->count();
        $totalCategories = Category::count();

        // Statistik hari ini
        $today = Carbon::today();
        $todayOrders = Order::whereDate('created_at', $today)->count();
        $todayRevenue = Order::whereDate('created_at', $today)
            ->whereIn('status', ['completed', 'paid'])
            ->sum('total_amount');

        // Statistik bulan ini
        $monthlyRevenue = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereIn('status', ['completed', 'paid'])
            ->sum('total_amount');

        $monthlyOrders = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Pesanan pending
        $pendingOrders = Order::where('status', 'pending')->count();

        // Revenue 7 hari terakhir untuk chart
        $revenueChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $revenue = Order::whereDate('created_at', $date)
                ->whereIn('status', ['completed', 'paid'])
                ->sum('total_amount');

            $revenueChart[] = [
                'date' => $date->format('M d'),
                'revenue' => $revenue
            ];
        }

        // Produk terpopuler (5 teratas)
        $popularProducts = OrderItem::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        // Pesanan terbaru
        $recentOrders = Order::with(['table', 'items'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Status meja
        $tableStats = [
            'available' => Table::where('status', 'available')->count(),
            'occupied' => Table::where('status', 'occupied')->count(),
            'reserved' => Table::where('status', 'reserved')->count(),
        ];

        return view('admin.dashboard.index', compact(
            'totalTables',
            'totalProducts',
            'totalCategories',
            'todayOrders',
            'todayRevenue',
            'monthlyRevenue',
            'monthlyOrders',
            'pendingOrders',
            'revenueChart',
            'popularProducts',
            'recentOrders',
            'tableStats'
        ));
    }
}
