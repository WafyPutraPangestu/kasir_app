<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman dasbor pesanan utama.
     */
    public function index(Request $request)
    {
        // Filter untuk tanggal (sekarang digunakan untuk tab Riwayat)
        $startDate = $request->get('start_date', Carbon::today()->subDays(7)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::today()->format('Y-m-d'));

        // [MODIFIKASI] Mengambil pesanan yang butuh tindakan (pending, paid, preparing)
        $activeOrders = Order::with(['table', 'items.product'])
            ->whereIn('status', ['pending', 'paid', 'preparing'])
            ->orderBy('created_at', 'desc')
            ->get();

        // [MODIFIKASI] Mengambil pesanan yang sudah selesai/final untuk tab riwayat
        $historyOrders = Order::with(['table', 'items.product'])
            ->whereIn('status', ['completed', 'cancelled'])
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik hari ini tetap sama
        $today = Carbon::today();
        $todayStats = [
            'total_orders' => Order::whereDate('created_at', $today)->count(),
            'total_revenue' => Order::whereDate('created_at', $today)
                ->whereIn('status', ['completed', 'paid'])
                ->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')
                ->whereDate('created_at', $today)->count(),
            'draft_orders' => Order::where('status', 'draft')
                ->whereDate('created_at', $today)->count(),
            'completed_orders' => Order::where('status', 'completed')
                ->whereDate('created_at', $today)->count()
        ];

        // [MODIFIKASI] Kirim variabel baru ke view
        return view('admin.orders.index', compact(
            'activeOrders',
            'historyOrders',
            'todayStats',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Mengupdate status pesanan.
     */
    public function updateStatus(Request $request, Order $order)
    {
        // Validasi tidak perlu diubah
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

    /**
     * Menampilkan detail pesanan.
     */
    public function show(Order $order)
    {
        try {
            $order->load(['table', 'items.product']);
            return response()->json(['success' => true, 'order' => $order]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengambil detail pesanan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Mengecek pesanan baru (termasuk yang baru dibayar).
     */
    public function checkNewOrders()
    {
        try {
            $lastCheck = session('last_order_check', now()->subMinutes(5));

            // [MODIFIKASI] Cek pesanan baru dengan status draft, pending, dan paid
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

    /**
     * [MODIFIKASI & GANTI NAMA] API untuk mengambil pesanan aktif.
     */
    public function getActiveOrders()
    {
        try {
            $orders = Order::with(['table', 'items.product'])
                ->whereIn('status', ['pending', 'paid', 'preparing'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json(['success' => true, 'orders' => $orders]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengambil pesanan aktif: ' . $e->getMessage()], 500);
        }
    }

    /**
     * [MODIFIKASI & GANTI NAMA] API untuk mengambil riwayat pesanan (laporan).
     */
    public function getOrderHistory(Request $request)
    {
        try {
            $startDate = $request->get('start_date', Carbon::today()->format('Y-m-d'));
            $endDate = $request->get('end_date', Carbon::today()->format('Y-m-d'));

            $reports = Order::with(['table', 'items.product'])
                ->whereIn('status', ['completed', 'cancelled']) // Hanya yang sudah final
                ->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json(['success' => true, 'reports' => $reports]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengambil riwayat pembayaran: ' . $e->getMessage()], 500);
        }
    }
}
