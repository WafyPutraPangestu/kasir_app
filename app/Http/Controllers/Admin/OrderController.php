<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::today()->subDays(7)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::today()->format('Y-m-d'));
        $activeOrders = Order::with(['table', 'items.product'])
            ->whereIn('status', ['pending', 'paid', 'preparing'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $historyOrders = Order::with(['table', 'items.product'])
            ->whereIn('status', ['completed', 'cancelled'])
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        $today = Carbon::today();
        $todayStats = [
            'total_orders' => Order::whereDate('created_at', $today)->count(),
            'total_revenue' => Order::whereDate('created_at', $today)
                ->whereIn('status', ['completed', 'paid'])
                ->sum('total_amount'),
            'pending_orders' => Order::where('status', 'paid')
                ->whereDate('created_at', $today)->count(),
            'draft_orders' => Order::where('status', 'draft')
                ->whereDate('created_at', $today)->count(),
            'completed_orders' => Order::where('status', 'completed')
                ->whereDate('created_at', $today)->count()
        ];
        return view('admin.orders.index', compact(
            'activeOrders',
            'historyOrders',
            'todayStats',
            'startDate',
            'endDate'
        ));
    }
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:draft,pending,paid,preparing,completed,cancelled'
        ]);
        try {
            $oldStatus = $order->status;
            $order->update(['status' => $request->status]);
            return response()->json([
                'success' => true,
                'message' => "Status pesanan berhasil diubah dari {$oldStatus} ke {$request->status}",
                'order' => $order->load(['table', 'items.product'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status: ' . $e->getMessage()
            ], 500);
        }
    }
    public function show(Order $order)
    {
        try {
            $order->load(['table', 'items.product']);
            return response()->json(['success' => true, 'order' => $order]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengambil detail pesanan: ' . $e->getMessage()], 500);
        }
    }
    public function checkNewOrders()
    {
        try {
            $lastCheck = session('last_order_check', now()->subMinutes(5));
            $newOrdersCount = Order::where('created_at', '>', $lastCheck)
                ->whereIn('status', ['draft', 'pending', 'paid'])
                ->count();
            session(['last_order_check' => now()]);
            return response()->json([
                'hasNew' => $newOrdersCount > 0,
                'count' => $newOrdersCount,
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            return response()->json(['hasNew' => false, 'count' => 0, 'error' => $e->getMessage()], 500);
        }
    }
    public function getActiveOrders(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 10);
            $orders = Order::with(['table', 'items.product'])
                ->whereIn('status', ['pending', 'paid', 'preparing'])
                ->orderBy('created_at', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);
            return response()->json([
                'success' => true,
                'orders' => $orders->items(),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'last_page' => $orders->lastPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                    'from' => $orders->firstItem(),
                    'to' => $orders->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengambil pesanan aktif: ' . $e->getMessage()], 500);
        }
    }
    public function getOrderHistory(Request $request)
    {
        try {
            $startDate = $request->get('start_date', Carbon::today()->format('Y-m-d'));
            $endDate = $request->get('end_date', Carbon::today()->format('Y-m-d'));
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 15);
            $reports = Order::with(['table', 'items.product'])
                ->whereIn('status', ['completed', 'cancelled'])
                ->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ])
                ->orderBy('created_at', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);
            return response()->json([
                'success' => true,
                'reports' => $reports->items(),
                'pagination' => [
                    'current_page' => $reports->currentPage(),
                    'last_page' => $reports->lastPage(),
                    'per_page' => $reports->perPage(),
                    'total' => $reports->total(),
                    'from' => $reports->firstItem(),
                    'to' => $reports->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengambil riwayat pembayaran: ' . $e->getMessage()], 500);
        }
    }
}
