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
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $totalTables = Table::count();
        $totalProducts = Product::where('is_active', true)->count();
        $totalCategories = Category::count();
        $today = Carbon::today();
        $todayOrders = Order::whereDate('created_at', $today)->count();
        $todayRevenue = Order::whereDate('created_at', $today)
            ->whereIn('status', ['completed', 'paid'])
            ->sum('total_amount');
        $monthlyRevenue = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereIn('status', ['completed', 'paid'])
            ->sum('total_amount');

        $monthlyOrders = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $revenueData = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completed', 'paid'])
            ->select(
                DB::raw('DATE(created_at) as order_date'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('order_date')
            ->get()
            ->keyBy(function ($item) {

                return Carbon::parse($item->order_date)->format('Y-m-d');
            });

        $revenueChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateString = $date->format('Y-m-d');
            $dailyData = $revenueData->get($dateString);

            $revenueChart[] = [
                'date' => $dateString,
                'revenue' => $dailyData ? $dailyData->revenue : 0,
            ];
        }
        $popularProducts = OrderItem::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();
        $recentOrders = Order::with(['table', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
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
