<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    public function __construct()
    {
        // Set konfigurasi Midtrans saat controller diinisialisasi
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    // ... method lain

    /**
     * Menghasilkan Snap Token untuk pembayaran pesanan.
     */
    public function createPayment(Order $order)
    {
        // Pastikan order ini milik user yang sedang login atau valid
        // (Tambahkan validasi sesuai kebutuhan Anda)

        // Cek jika order sudah memiliki snap_token atau sudah lunas
        if ($order->snap_token || $order->status === 'paid') {
            return response()->json(['message' => 'Payment already processed or exists.'], 400);
        }

        // Detail Transaksi
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->id . '-' . time(), // ID unik untuk setiap transaksi
                'gross_amount' => $order->total_amount,
            ],
            // 'item_details' => $item_details, // Opsional: jika Anda ingin menyertakan detail item
            'customer_details' => [
                // Asumsi user sudah login, atau ambil dari data lain
                'first_name' => Auth::user()->name ?? 'Customer',
                'email' => Auth::user()->email ?? 'customer@example.com',
            ],
        ];

        try {
            // Dapatkan Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan snap_token ke database order Anda
            $order->snap_token = $snapToken;
            $order->save();

            // Kembalikan token ke frontend
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleCallback(Request $request)
    {
        $notification = new \Midtrans\Notification();

        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraudStatus = $notification->fraud_status;

        // Ekstrak ID order asli dari order_id transaksi
        // (Berdasarkan format 'ORDER-' . $order->id . '-' . time())
        $orderIdParts = explode('-', $orderId);
        $realOrderId = $orderIdParts[1];

        $order = Order::find($realOrderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        // Log notifikasi untuk debugging
        Log::info('Midtrans Notification:', $request->all());

        // Validasi signature key (opsional tapi sangat direkomendasikan)
        $signatureKey = hash('sha512', $orderId . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));
        if ($notification->signature_key != $signatureKey) {
            return response()->json(['message' => 'Invalid signature.'], 403);
        }

        // Update status order berdasarkan notifikasi
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            // 'capture' untuk kartu kredit, 'settlement' untuk metode lain
            if ($fraudStatus == 'accept') {
                $order->status = 'paid';
                $order->payment_ref = $notification->transaction_id;
                $order->save();
            }
        } else if ($transactionStatus == 'pending') {
            $order->status = 'pending';
            $order->save();
        } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $order->status = 'cancelled';
            $order->save();
        }

        return response()->json(['message' => 'Notification handled.']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
