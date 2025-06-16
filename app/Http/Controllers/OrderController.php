<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class OrderController extends Controller
{
  public function __construct()
  {
    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = config('midtrans.is_production');
    \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
    \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
  }

  public function store(Request $request)
  {
    $tableId = Session::get('table_id');
    $tableName = Session::get('table_name');

    if (!$tableId) {
      return response()->json([
        'success' => false,
        'message' => 'Meja tidak ditemukan. Silakan scan QR code kembali.'
      ], 400);
    }

    if (Cart::count() === 0) {
      return response()->json([
        'success' => false,
        'message' => 'Keranjang belanja kosong'
      ], 400);
    }

    try {
      $order = new Order();
      $order->table_id = $tableId;
      $order->status = 'pending';
      $order->total_amount = (float) str_replace(',', '', Cart::subtotal());
      $order->save();

      foreach (Cart::content() as $item) {
        $orderItem = new OrderItem();
        $orderItem->order_id = $order->id;
        $orderItem->product_id = $item->id;
        $orderItem->quantity = $item->qty;
        $orderItem->price = $item->price;
        $orderItem->save();
      }

      Cart::destroy();

      return response()->json([
        'success' => true,
        'message' => 'Order berhasil dibuat',
        'order_id' => $order->id,
        'redirect' => route('orders.show', $order),
        'table_name' => $tableName
      ]);
    } catch (\Exception $e) {
      Log::error('Error creating order: ' . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => 'Gagal membuat order: ' . $e->getMessage()
      ], 500);
    }
  }

  public function show(Order $order)
  {
    $order->load('items.product', 'table');
    return view('customer.order', ['order' => $order]);
  }

  public function createPayment(Order $order)
  {
    if ($order->status !== 'pending') {
      return response()->json(['message' => 'Order tidak dapat dibayar'], 400);
    }

    try {
      // Buat order_id unik untuk Midtrans
      $midtransOrderId = 'ORDER-' . $order->id . '-' . time() . '-' . Str::random(4);

      $params = [
        'transaction_details' => [
          'order_id' => $midtransOrderId,
          'gross_amount' => (int) round($order->total_amount),
        ],
        'customer_details' => [
          'first_name' => 'Meja ' . $order->table->name,
          'product' => 'Pesanan Meja ' . $order->items->pluck('product.name')->implode(', '),
        ],
      ];

      $snapToken = \Midtrans\Snap::getSnapToken($params);
      $order->snap_token = $snapToken;
      $order->midtrans_order_id = $midtransOrderId; // Simpan order_id Midtrans
      $order->save();

      return response()->json([
        'snap_token' => $snapToken,
        'redirect_url' => route('orders.status', $order)
      ]);
    } catch (\Exception $e) {
      Log::error('Payment error: ' . $e->getMessage());
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }


  public function showStatusPage(Order $order)
  {
    return view('customer.order-status', compact('order'));
  }

  public function checkStatus(Order $order)
  {
    if ($order->status === 'paid') {
      return response()->json([
        'status' => $order->status,
        'message' => 'Pembayaran berhasil'
      ]);
    }

    try {
      // Gunakan midtrans_order_id untuk pengecekan status
      $orderIdToCheck = $order->midtrans_order_id ?? $order->payment_ref;

      if (!$orderIdToCheck) {
        throw new \Exception('Midtrans order ID not found');
      }

      $midtransStatus = \Midtrans\Transaction::status($orderIdToCheck);

      if (!is_object($midtransStatus)) {
        throw new \Exception('Invalid Midtrans response format');
      }

      Log::debug('Midtrans status response:', (array) $midtransStatus);

      if (!property_exists($midtransStatus, 'transaction_status')) {
        throw new \Exception('Invalid Midtrans response: missing transaction_status');
      }

      $newStatus = $this->mapMidtransStatus($midtransStatus->transaction_status);

      if ($newStatus !== $order->status) {
        $order->status = $newStatus;

        // Simpan transaction_id tanpa menghilangkan midtrans_order_id
        if (!empty($midtransStatus->transaction_id)) {
          $order->payment_ref = $midtransStatus->transaction_id;
        }
        if (!empty($midtransStatus->payment_type)) {
          $order->payment_type = $midtransStatus->payment_type;
        }

        $order->save();
      }

      if (empty($order->midtrans_order_id)) {
        Log::warning('Midtrans order_id kosong saat checkStatus dipanggil. Order ID: ' . $order->id);
        return response()->json([
          'status' => $order->status,
          'message' => 'Menunggu informasi pembayaran dibuat...'
        ]);
      }
    } catch (\Exception $e) {
      Log::error('Error checking payment status: ' . $e->getMessage());
      return response()->json([
        'status' => $order->status,
        'message' => 'Gagal memeriksa status pembayaran'
      ]);
    }
  }

  private function mapMidtransStatus($midtransStatus)
  {
    $statusMap = [
      'capture' => 'paid',
      'settlement' => 'paid',
      'pending' => 'pending',
      'deny' => 'deny',
      'expire' => 'expire',
      'cancel' => 'cancelled'
    ];

    return $statusMap[$midtransStatus] ?? 'pending';
  }

  private function getStatusMessage($status)
  {
    $messages = [
      'pending' => 'Menunggu pembayaran',
      'paid' => 'Pembayaran berhasil',
      'cancelled' => 'Pesanan dibatalkan',
      'expire' => 'Pembayaran kadaluarsa',
      'deny' => 'Pembayaran ditolak',
    ];

    return $messages[$status] ?? 'Status tidak diketahui';
  }
  public function cancel(Order $order)
  {
    if (in_array($order->status, ['draft', 'pending'])) {
      $order->status = 'cancelled';
      $order->save();

      return response()->json([
        'success' => true,
        'redirect_url' => route('customer.menu', ['qr_token' => $order->table->qr_token]),
        'message' => 'Pesanan berhasil dibatalkan.'
      ]);
    }

    return response()->json([
      'success' => false,
      'message' => 'Pesanan tidak bisa dibatalkan.'
    ], 400);
  }



  public function success(Request $request)
  {
    return view('customer.success', [
      'order' => Order::latest()->first(),
      'table_name' => Session::get('table_name')
    ]);
  }
}
